<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone_number',
        'qr_code',
        'payment_method',
        'due_date',
        'amount',
        'status',
        'receipt_path',
        'reasons',
    ];
    protected $casts = [
        'due_date' => 'array',
    ];
}
