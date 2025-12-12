<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = ['nombre', 'telefono', 'email', 'direccion', 'estado'];

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class, 'proveedor_id');
    }
}
