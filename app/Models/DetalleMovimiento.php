<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleMovimiento extends Model
{
    protected $table = 'detalles_movimiento';
    protected $fillable = [
        'movimiento_id', 'producto_id', 'cantidad', 'precio_unitario', 
        'subtotal', 'monto_impuesto', 'unidad_id'
    ];

    public function movimiento(): BelongsTo
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }
}
