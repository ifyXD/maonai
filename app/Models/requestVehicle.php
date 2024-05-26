<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requestVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vehicle_id',
        'capacity',
        'purpose',
        'status',
        'user_id',
        'drivers_id',
        'appointment',
        'appointment_end',
        'isdel',
    ];

    // Define the relationship
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'drivers_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
