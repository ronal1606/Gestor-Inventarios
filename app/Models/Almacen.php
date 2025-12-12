<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Almacen extends Model
{
    protected $table = 'almacenes';
    protected $fillable = ['nombre', 'direccion', 'es_predeterminado'];

    public function stocks(): HasMany
    {
        return $this->hasMany(StockAlmacen::class, 'almacen_id');
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class, 'almacen_id');
    }
}
