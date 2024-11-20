<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caracteristica extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','descripcion'];

    public function categoria()
    {
        return $this->hasOne(Categoria::class);
    }

    public function marca()
    {
        return $this->hasOne(Marca::class);
    }
}
