<?php

use App\Livewire\MovimientoSalida;
use App\Livewire\MovimientoEntrada;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/movimientos/salida', MovimientoSalida::class)
        ->name('movimiento.salida');

    Route::get('/admin/movimientos/entrada', MovimientoEntrada::class)
        ->name('movimiento.entrada');
});
