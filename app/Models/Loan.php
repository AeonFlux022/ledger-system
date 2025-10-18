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

    /**
     * Relationship: Loan belongs to a Borrower
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
     * Generate amortization schedule
     */
    // public function amortizationSchedule(): Collection
    // {
    //     $schedule = collect();
    //     $startDate = Carbon::parse($this->due_date);

    //     for ($i = 1; $i <= $this->terms; $i++) {
    //         $dueDate = $startDate->copy()->addMonths($i - 1);

    //         // check if there's already a payment for this month
    //         $payment = $this->payments()
    //             ->where('month', $i)
    //             ->first();

    //         $schedule->push([
    //             'month' => $i,
    //             'due_date' => $dueDate->format('Y-m-d'),
    //             'amount' => round($this->monthly_amortization, 2),
    //             'status' => $payment ? 'paid' : 'unpaid',
    //             'payment_id' => $payment->id ?? null,
    //             'paid_amount' => $payment->amount ?? null,
    //             'paid_date' => $payment->created_at ?? null,
    //         ]);
    //     }

    //     return $schedule;
    // }

    public function amortizationSchedule(): Collection
    {
        $schedule = collect();
        $startDate = Carbon::parse($this->due_date);

        $totalPayable = round($this->total_payable, 2); // total loan payable
        $monthly = round($this->monthly_amortization, 2);

        $accumulated = 0; // keep track of amortizations added so far

        for ($i = 1; $i <= $this->terms; $i++) {
            $dueDate = $startDate->copy()->addMonths($i - 1);

            // Default amount = monthly amortization
            $amount = $monthly;

            // For the last term, adjust so total = totalPayable
            if ($i == $this->terms) {
                $amount = $totalPayable - $accumulated;
                $amount = round($amount, 2); // ensure 2 decimals
            }

            $accumulated += $amount;

            // check if there's already a payment for this month
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


    // Calculate overdues
    public function calculateOverdues()
    {
        $today = now();
        $penalty = 0;

        foreach ($this->amortizationSchedule() as $row) {  // assuming you have a schedule generator
            $dueDate = \Carbon\Carbon::parse($row['due_date']);

            $alreadyPaid = $this->payments->firstWhere('month', $row['month']);

            if ($today->greaterThan($dueDate) && !$alreadyPaid) {
                // 1% penalty of that month’s amortization
                $monthsOverdue = $dueDate->diffInMonths($today);
                $penalty += $row['amount'] * 0.01;
            }
        }

        return round($penalty, 2);
    }

    // Accessor for loan status
    public function getLoanStatusAttribute()
    {
        // If loan is completed, always mark as current
        if ($this->status === 'completed') {
            return 'Current';
        }

        // If today is past due_date and balance > 0 → Overdue
        if (now()->greaterThan($this->due_date) && $this->outstanding_balance > 0) {
            return 'Overdue';
        }

        return 'Current';
    }

    // Accessor for last payment date
    public function getLastPaymentDateAttribute()
    {
        $lastPayment = $this->payments()->latest('created_at')->first();

        return $lastPayment ? $lastPayment->created_at->format('M d, Y') : '—';
    }

    // Accessor for balance with overdue
    public function getBalanceWithOverdueAttribute(): float
    {
        return round($this->outstanding_balance + $this->calculateOverdues(), 2);
    }

}
