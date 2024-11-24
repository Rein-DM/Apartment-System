<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'message',
        'status',
    ];
}
