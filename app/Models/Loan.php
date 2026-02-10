<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrower_id',
        'loan_amount',
        'interest_rate',
        'terms',
        'processing_fee',
        'due_date',
        'monthly_amortization',
        'overdue',
        'total_payable',
        'outstanding_balance',
        'status',
        'loan_status',
        'reason',
    ];

    /**
     * 🔹 Relationship: Loan belongs to a Borrower
     */
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * 🔹 Total contract value (principal + interest + processing)
     */
    // public function getTotalObligationAttribute(): float
    // {
    //     return round(
    //         ($this->loan_amount ?? 0)
    //         + (($this->total_payable ?? 0) - ($this->loan_amount ?? 0)) // interest part
    //         + ($this->processing_fee ?? 0),
    //         2
    //     );
    // }

    // total payable per term including penalties
    public function payableForMonth(int $month): float
    {
        // check if there's already a payment record for this term
        $paid = $this->payments->firstWhere('month', $month);

        if ($paid) {
            // use stored DB values (frozen truth once paid)
            return round($paid->total_paid, 2);
        }

        // not yet paid → compute live
        $schedule = collect($this->amortizationSchedule());
        $row = $schedule->firstWhere('month', $month);

        if (!$row) {
            return 0;
        }

        $base = $row['amount'];
        $penalty = $this->calculatePenaltyForMonth($month);

        return round($base + $penalty, 2);
    }


    /**
     * 🔹 Total amount paid including penalties
     */
    public function getTotalPaidAttribute(): float
    {
        return round($this->payments()->sum('total_paid'), 2);
    }

    /**
     * 🔹 Remaining balance (global source of truth)
     */
    public function getRemainingBalanceAttribute(): float
    {
        return max(
            round($this->total_payable - $this->total_paid, 2),
            0
        );
    }

    /**
     * 🔹 Running balance per payment (ledger style)
     */
    public function runningBalanceAfter(Payment $payment): float
    {
        $paidBefore = $this->payments()
            ->where('id', '<=', $payment->id)
            ->sum('total_paid');

        return max(
            round($this->total_payable - $paidBefore, 2),
            0
        );
    }

    public function runningTotalPaid(Payment $payment): float
    {
        return round(
            $this->payments()
                ->where('id', '<=', $payment->id)
                ->sum('total_paid'),
            2
        );
    }

    /**
     * 🔹 Generate Amortization Schedule
     */
    public function amortizationSchedule(): Collection
    {
        $schedule = collect();
        $startDate = Carbon::parse($this->due_date);

        $totalPayable = round($this->total_payable, 2);
        $monthly = round($this->monthly_amortization, 2);
        $accumulated = 0;

        for ($i = 1; $i <= $this->terms; $i++) {
            $dueDate = $startDate->copy()->addMonths($i - 1);
            $amount = $monthly;

            if ($i == $this->terms) {
                $amount = $totalPayable - $accumulated;
                $amount = round($amount, 2);
            }

            $accumulated += $amount;

            $payment = $this->payments()->where('month', $i)->first();

            $schedule->push([
                'month' => $i,
                'due_date' => $dueDate->format('Y-m-d'),
                'amount' => $amount,
                'status' => $payment ? 'paid' : 'unpaid',
                'payment_id' => $payment->id ?? null,
                'paid_amount' => $payment->amount ?? null,
                'paid_date' => $payment->created_at ?? null,
            ]);
        }

        return $schedule;
    }

    /**
     * 🔹 Calculate overdue penalties
     */
    public function calculatePenaltyForMonth($month)
    {
        $schedule = collect($this->amortizationSchedule());
        $row = $schedule->firstWhere('month', $month);

        if (!$row)
            return 0;

        $dueDate = Carbon::parse($row['due_date']);
        $alreadyPaid = $this->payments->firstWhere('month', $month);

        // 3% penalty only if overdue and unpaid
        if (now()->greaterThan($dueDate) && !$alreadyPaid) {
            return round($row['amount'] * 0.03, 2);
        }

        return 0;
    }

    public function calculateOverdues()
    {
        $penalty = 0;

        foreach ($this->amortizationSchedule() as $row) {
            $month = $row['month'];

            // if already paid, DO NOT re-penalize
            $alreadyPaid = $this->payments->firstWhere('month', $month);
            if ($alreadyPaid) {
                continue;
            }

            $penalty += $this->calculatePenaltyForMonth($month);
        }

        return round($penalty, 2);
    }


    public function getLastPaymentDateAttribute()
    {
        $lastPayment = $this->payments()->latest('created_at')->first();

        return $lastPayment ? $lastPayment->created_at->format('M d, Y') : '—';
    }

    public function getPayablePerTermAttribute(): float
    {
        if ($this->terms > 0 && $this->total_payable > 0) {
            return round($this->total_payable / $this->terms, 2);
        }

        return 0;
    }

    public function getDisplayBalanceAttribute(): float
    {
        return $this->loan_status === 'completed'
            ? 0
            : $this->remaining_balance;
    }


    /**
     * 🔹 Starting balance before a specific payment
     */
    public function startingBalanceBefore(Payment $payment): float
    {
        $paidBefore = $this->payments()
            ->where('id', '<', $payment->id)
            ->sum('total_paid');

        return max(
            round($this->total_payable - $paidBefore, 2),
            0
        );
    }


    // check for loan status
    public function updateLoanStatus(): void
    {
        $today = now();

        // 1. If fully paid (true accounting balance)
        if ($this->remaining_balance <= 0) {
            $this->loan_status = 'completed';
            $this->save();
            return;
        }

        // 2. Check if there is any overdue unpaid term
        $schedule = $this->amortizationSchedule();

        $nextUnpaid = collect($schedule)->firstWhere('status', 'unpaid');

        if ($nextUnpaid) {
            $dueDate = Carbon::parse($nextUnpaid['due_date']);

            if ($today->greaterThan($dueDate)) {
                $this->loan_status = 'overdue';
            } else {
                $this->loan_status = 'current';
            }
        } else {
            // fallback
            $this->loan_status = 'current';
        }

        $this->save();
    }


    protected static function booted()
    {
        static::retrieved(function ($loan) {
            $loan->updateLoanStatus();
        });
    }

    public function getOutstandingBalanceAttribute($value)
    {
        if (!is_null($value))
            return $value;

        $paidBase = $this->payments()->sum('amount'); // base only
        return max(0, $this->total_payable - $paidBase);
    }



}
