<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'type',
        'price',
        'capacity',
        'description',
        'available',
        'apartment_image',
        'bathroom_image',
        'outside_image',
        'occupied_image',
        'vacant_image',
        'status',
    ];
    
    public function apartmentRooms()
    {
        return $this->hasMany(ApartmentRoom::class);
    }
}
