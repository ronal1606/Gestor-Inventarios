<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemListaPrecios extends Model
{
    protected $table = 'items_lista_precios';
    protected $fillable = ['lista_precios_id', 'producto_id', 'precio'];

    public function listaPrecios(): BelongsTo
    {
        return $this->belongsTo(ListaPrecios::class, 'lista_precios_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
