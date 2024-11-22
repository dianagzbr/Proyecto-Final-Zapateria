<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'nombre', 'descripcion', 'marca_id', 'categoria_id', 'img_path'];

    public function compras()
    {
        return $this->belongsToMany(Compra::class)->withTimestamps()->withPivot('cantidad', 'precio_compra', 'precio_venta');
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class)->withTimestamps()->withPivot('cantidad', 'precio_venta', 'descuento');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function tallas()
    {
        return $this->belongsToMany(Talla::class, 'producto_talla')->withPivot('cantidad')->withTimestamps();
    }
}
