<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedore extends Model
{
    use HasFactory;

    protected $fillable = ['persona_id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
