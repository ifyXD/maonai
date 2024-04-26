<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable = [
        'evaluation',
        'condition',
        'timefinish',
        'status',
        'isdel',
    ];
}
