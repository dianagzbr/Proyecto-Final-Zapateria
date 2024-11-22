<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['caracteristica_id'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class);
    }
}
