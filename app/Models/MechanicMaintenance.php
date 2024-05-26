<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicMaintenance extends Model
{

    protected $fillable = [
        'mechanic_name',
        'mechanic_id',
        'maintenance_id',
    ];
    use HasFactory;
}
