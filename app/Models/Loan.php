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
    ];

    // 🔹 Auto-update loan status when loading or saving
    protected static function booted()
    {
        static::retrieved(function ($loan) {
            $loan->autoUpdateStatus();
        });

        static::saving(function ($loan) {
            $loan->autoUpdateStatus();
        });
    }

    /**
     * 🔹 Automatically update the loan status
     */
    public function autoUpdateStatus()
    {
        $now = Carbon::now();

        if ($this->outstanding_balance <= 0) {
            $this->status = 'completed';
        } elseif ($now->greaterThan(Carbon::parse($this->due_date)) && $this->outstanding_balance > 0) {
            $this->status = 'overdue';
        } elseif (!in_array($this->status, ['approved', 'pending', 'rejected', 'completed', 'overdue'])) {
            $this->status = 'pending';
        }
    }

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
                $penalty += $row['amount'] * 0.01; // 1% penalty
            }
        }

        return round($penalty, 2);
    }

    /**
     * 🔹 Accessor for human-readable loan status
     */
    public function getLoanStatusAttribute()
    {
        if ($this->status === 'completed') {
            return 'Completed';
        }

        if (now()->greaterThan($this->due_date) && $this->outstanding_balance > 0) {
            return 'Overdue';
        }

        return 'Current';
    }

    /**
     * 🔹 Accessor for last payment date
     */
    public function getLastPaymentDateAttribute()
    {
        $lastPayment = $this->payments()->latest('created_at')->first();

        return $lastPayment ? $lastPayment->created_at->format('M d, Y') : '—';
    }

    /**
     * 🔹 Accessor for balance including overdue penalty
     */
    public function getBalanceWithOverdueAttribute(): float
    {
        return round($this->outstanding_balance + $this->calculateOverdues(), 2);
    }
}
