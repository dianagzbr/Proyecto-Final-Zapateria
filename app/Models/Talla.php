<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Talla extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function productos()
    {
    return $this->belongsToMany(Producto::class, 'producto_talla')->withPivot('cantidad')->withTimestamps();
    }
}
