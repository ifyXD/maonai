<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanics extends Model
{
    use HasFactory;
    protected $fillable = [
        'mechanics_name',
        'contact',
        'email',
        'description',
        'status',
        'isdel',
    ];
}
