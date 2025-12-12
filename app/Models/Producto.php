<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = [
        'categoria_id', 'nombre', 'codigo', 'descripcion', 
        'precio_compra', 'precio_venta', 'stock_minimo', 'stock_actual',
        'unidad_id', 'tasa_impuesto', 'impuesto_incluido', 'estado'
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(DetalleMovimiento::class, 'producto_id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(StockAlmacen::class, 'producto_id');
    }
}
