<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_name',
        'contact',
        'email',
        'driver_license',
        'address',
        'status',
        'driver',
        'isdel'
    ];
    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'vehicles_id', 'id');
    }
}
