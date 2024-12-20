<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['fecha_hora', 'impuesto', 'numero_comprobante', 'total', 'comprobante_id', 'proveedore_id'];

    protected $dates = ['deleted_at'];
    
    public function proveedore()
    {
        return $this->belongsTo(Proveedore::class);
    }

    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withTimestamps()->withPivot('cantidad','precio_compra','precio_venta');
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }
}
