<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'name', 'rate', 'hours', 'amount', 'role', 'contact_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
