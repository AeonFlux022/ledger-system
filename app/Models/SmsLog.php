<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'loan_id',
        'borrower_id',
        'phone_number',
        'message',
        'success',
        'response',
        'type',
        'fname',
        'lname',
    ];

    /**
     * Relationships
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    /**
     * Optional: Accessor for full name
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->fname} {$this->lname}");
    }
}
