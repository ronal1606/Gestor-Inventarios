<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListaPrecios extends Model
{
    protected $table = 'listas_precios';
    protected $fillable = ['nombre', 'descripcion', 'es_predeterminada', 'estado'];

    public function items(): HasMany
    {
        return $this->hasMany(ItemListaPrecios::class, 'lista_precios_id');
    }

    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class, 'lista_precios_id');
    }
}
