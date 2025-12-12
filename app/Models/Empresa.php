<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $fillable = [
        'nombre', 'telefono', 'direccion', 'email', 
        'logo', 'color_primario', 'color_secundario'
    ];
}
