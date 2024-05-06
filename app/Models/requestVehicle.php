<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requestVehicle extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'vehicle_id',
        'user_id',
        'purpose',
        'status',
        'appointment',
        'isdel',
    ];
}
