<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Movimientos (SALIDA y ENTRADA)
require __DIR__ . '/movimientos.php';
