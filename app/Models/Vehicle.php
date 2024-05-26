<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'platenumber',
        'type',
        'driver_id',
        'fuel_id',
        'condition',
        'description',
        'status', 
        'seat_capacity',
        'isdel',
    ];
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'drivers_id', 'id');
    }
    public function requestVehicles()
    {
        return $this->hasOne(RequestVehicle::class ,'vehicle_id', 'id');
    }
}