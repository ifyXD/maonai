<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripDestination extends Model
{
    use HasFactory;

    protected $fillable = ['where','point','purpose','user_id','vehicle_id,'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicles_id', 'id');
    }
}
