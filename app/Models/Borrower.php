<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'lname',
        'address',
        'contact_number',
        'alt_number',
        'email',
        'id_card',
        'id_image',
        'income',
        'employment_status',

    ];

    /**
     * Relationship: Borrower has many Loans
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }


    /**
     * Accessor: Get full name easily
     */
    public function getFullNameAttribute()
    {
        return "{$this->fname} {$this->lname}";
    }

    /**
     * Format income with ₱ and commas
     */
    public function getFormattedIncomeAttribute()
    {
        return '₱' . number_format($this->income, 2);
    }

    public function canBeDeleted(): bool
    {
        return $this->loans()->count() === 0;
    }
}
