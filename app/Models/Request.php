<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'content', 'quantity', 'unit_cost', 'total_cost', 'labor_needed', 'status'];
 // Fillable fields

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
