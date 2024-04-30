<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'fuel_type',
        'fuel_quantity',
        'fuel_cost',
        'status',
    ];

}
