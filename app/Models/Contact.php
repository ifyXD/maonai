<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'department', 'content']; // Added 'content'

     // Define the relationship
     public function user()
     {
         return $this->belongsTo(User::class);
     }

    public function labors()
    {
        return $this->hasMany(Labor::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }


}
