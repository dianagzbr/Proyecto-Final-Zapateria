<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['persona_id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
