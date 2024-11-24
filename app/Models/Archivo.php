<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'ruta'];

    public function archivable()
    {
        return $this->morphTo(); //Relación polimórfica
    }
}
