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
        'condition',
        'description',
        'status',
        'drivers_id',
        'isdel',
    ];
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'drivers_id', 'id');
    }
}