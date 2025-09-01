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
        'status',
    ];

    /**
     * Relationship: Loan belongs to a Borrower
     */
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }



    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Total payable (loan + interest + processing fee)
     */
    public function getTotalPayableAttribute()
    {
        $interest = $this->loan_amount * ($this->interest_rate / 100) * $this->terms;

        return $this->loan_amount + $interest + $this->processing_fee;
    }

    /**
     * Expected due date (based on terms from creation date)
     */
    public function getExpectedDueDateAttribute()
    {
        return Carbon::parse($this->created_at)->addMonths($this->terms);
    }

    /**
     * Monthly amortization
     */
    public function getMonthlyAmortizationAttribute()
    {
        if ($this->terms > 0) {
            return $this->total_payable / $this->terms;
        }
        return 0;
    }

    /**
     * Amortization schedule
     */
    public function amortizationSchedule(): Collection
    {
        $schedule = collect();
        $monthly = $this->monthly_amortization;
        $due_date = Carbon::parse($this->due_date);

        for ($i = 1; $i <= $this->terms; $i++) {
            $schedule->push([
                'month' => $i,
                'due_date' => $due_date->copy()->subMonths($this->terms - $i)->toDateString(),
                'amount' => $monthly,
            ]);
        }

        return $schedule;
    }

    /**
     * Accessor: Format loan amount for display
     */
    public function getFormattedAmountAttribute()
    {
        return '₱' . number_format($this->loan_amount, 2);
    }

    /**
     * Accessor: Format total payable for display
     */
    public function getFormattedTotalPayableAttribute()
    {
        return '₱' . number_format($this->total_payable, 2);
    }

    /**
     * Accessor: Borrower full name (safe call)
     */
    public function getBorrowerNameAttribute()
    {
        return $this->borrower ? $this->borrower->fname . ' ' . $this->borrower->lname : 'N/A';
    }
}
