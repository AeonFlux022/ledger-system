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
    public function amortizationSchedule(): Collection
    {
        $schedule = collect();
        $startDate = Carbon::parse($this->due_date);

        for ($i = 1; $i <= $this->terms; $i++) {
            $dueDate = $startDate->copy()->addMonths($i - 1);

            // check if there's already a payment for this month
            $payment = $this->payments()
                ->where('month', $i)
                ->first();

            $schedule->push([
                'month' => $i,
                'due_date' => $dueDate->format('Y-m-d'),
                'amount' => round($this->monthly_amortization, 2),
                'status' => $payment ? 'paid' : 'unpaid',
                'payment_id' => $payment->id ?? null,
                'paid_amount' => $payment->amount ?? null,
                'paid_date' => $payment->created_at ?? null,
            ]);
        }

        return $schedule;
    }

}
