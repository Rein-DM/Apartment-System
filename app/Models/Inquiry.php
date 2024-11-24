<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'contact_number',
        'email',
        'price',
        'room_number',
        'valid_id',
        'agreement',
        'inquiry_status',
        'status',
    ];
}

