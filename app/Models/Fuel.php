<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;
    protected $fillable = [
        'fuel_type',
        'fuel_quantity',
        'fuel_cost',
        'status',
        'isdel',
    ];
    protected $casts = [
        'fuel_quantity' => 'decimal:2',
        'fuel_cost' => 'decimal:2',
    ];

}
