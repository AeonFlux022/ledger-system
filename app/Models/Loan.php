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
    public function calculateOverdues()
    {
        $today = now();
        $penalty = 0;

        foreach ($this->amortizationSchedule() as $row) {
            $dueDate = Carbon::parse($row['due_date']);
            $alreadyPaid = $this->payments->firstWhere('month', $row['month']);

            if ($today->greaterThan($dueDate) && !$alreadyPaid) {
                $penalty += $row['amount'] * 0.03; // 1% penalty
            }
        }

        return round($penalty, 2);
    }

    /**
     * 🔹 Accessor for balance including overdue penalty
     */
    public function getBalanceWithOverdueAttribute(): float
    {
        return round($this->outstanding_balance + $this->calculateOverdues(), 2);
    }

    public function getDisplayBalanceAttribute()
    {
        return $this->loan_status === 'completed'
            ? 0
            : $this->balance_with_overdue;
    }

    /**
     * 🔹 Accessor for last payment date
     */
    public function getLastPaymentDateAttribute()
    {
        $lastPayment = $this->payments()->latest('created_at')->first();

        return $lastPayment ? $lastPayment->created_at->format('M d, Y') : '—';
    }




    // check for loan status
    public function updateLoanStatus(): void
    {
        $today = now();
        $schedule = $this->amortizationSchedule();

        $paidCount = $this->payments()->count();

        // If fully paid
        if ($paidCount >= $this->terms) {
            $this->loan_status = 'completed';
        } else {
            // Find the latest unpaid due date
            $nextUnpaid = $schedule->firstWhere('status', 'unpaid');

            if ($nextUnpaid) {
                $dueDate = Carbon::parse($nextUnpaid['due_date']);

                // Overdue if today is past due and unpaid
                if ($today->greaterThan($dueDate)) {
                    $this->loan_status = 'overdue';
                }
                // Otherwise, still current
                else {
                    $this->loan_status = 'current';
                }
            } else {
                // If somehow all paid but terms don't match (edge case)
                $this->loan_status = 'completed';
            }
        }

        $this->save();
    }
    protected static function booted()
    {
        static::retrieved(function ($loan) {
            $loan->updateLoanStatus();
        });
    }


}
