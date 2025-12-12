<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['nombre', 'email', 'telefono', 'direccion', 'estado', 'lista_precios_id'];

    public function listaPrecios(): BelongsTo
    {
        return $this->belongsTo(ListaPrecios::class, 'lista_precios_id');
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class, 'cliente_id');
    }
}
