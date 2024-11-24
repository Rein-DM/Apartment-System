<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentRoom extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'full_name', 'contact_number', 'email', 'valid_id', 'start_date', 'end_date', 'status'];
}
