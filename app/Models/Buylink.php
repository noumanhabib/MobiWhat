<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buylink extends Model
{
    public function mobile()
    {
        return $this->belongsTo(Mobile::class);
    }
    use HasFactory;
}