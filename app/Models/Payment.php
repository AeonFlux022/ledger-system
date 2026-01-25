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
        'penalty',
        'due_date',
        'total_paid'
    ];
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

}
