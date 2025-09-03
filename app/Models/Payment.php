<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'loan_id',
        'month',
        'reference_id',
        'amount',
    ];
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    // Always calculate outstanding balance dynamically
    public function getOutstandingBalanceAttribute($value)
    {
        if (!is_null($value)) {
            return $value; // Use stored value if maintained
        }

        $paid = $this->payments()->sum('amount');
        return max(0, $this->total_payable - $paid);
    }

}

