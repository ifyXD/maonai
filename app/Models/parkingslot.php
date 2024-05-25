<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class parkingslot extends Model
{
    use HasFactory;

    protected $fillable = [

        'slot',
        'description',
    ];
}
