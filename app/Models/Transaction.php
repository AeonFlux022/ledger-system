<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount',
        'reference_id',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
