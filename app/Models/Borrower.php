<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $fillable = [
        'fname',
        'lname',
        'address',
        'contact_number',
        'email',
        'id_card',
        'id_image',
        'income',
        'employment_status',
    ];
}
