<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function getTotalPayableAttribute()
    {
        $interest = $this->loan_amount * ($this->interest_rate / 100) * $this->terms;

        return $this->loan_amount + $interest + $this->processing_fee;
    }


    public function getExpectedDueDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->addMonths($this->terms);
    }

    public function getMonthlyAmortizationAttribute()
    {
        if ($this->terms > 0) {
            return $this->total_payable / $this->terms;
        }
        return 0;
    }

    public function amortizationSchedule(): Collection
    {
        $schedule = collect();
        $monthly = $this->monthly_amortization;
        $due_date = \Carbon\Carbon::parse($this->due_date);

        for ($i = 1; $i <= $this->terms; $i++) {
            $schedule->push([
                'month' => $i,
                'due_date' => $due_date->copy()->subMonths($this->terms - $i)->toDateString(),
                'amount' => $monthly,
            ]);
        }

        return $schedule;
    }

}
