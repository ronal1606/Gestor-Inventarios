<?php

namespace App\Observers;

use App\Models\DetalleMovimiento;
use App\Models\Producto;

class DetalleMovimientoObserver
{
    /**
     * Handle the DetalleMovimiento "created" event.
     */
    public function created(DetalleMovimiento $detalleMovimiento): void
    {
        $this->actualizarStock($detalleMovimiento);
    }

    /**
     * Handle the DetalleMovimiento "updated" event.
     */
    public function updated(DetalleMovimiento $detalleMovimiento): void
    {
        if ($detalleMovimiento->wasChanged(['cantidad', 'producto_id'])) {
            // Revertir stock anterior
            if ($detalleMovimiento->getOriginal('producto_id')) {
                $this->revertirStock($detalleMovimiento->getOriginal());
            }
            // Aplicar nuevo stock
            $this->actualizarStock($detalleMovimiento);
        }
    }

    /**
     * Handle the DetalleMovimiento "deleted" event.
     */
    public function deleted(DetalleMovimiento $detalleMovimiento): void
    {
        $this->revertirStock($detalleMovimiento);
    }

    /**
     * Handle the DetalleMovimiento "restored" event.
     */
    public function restored(DetalleMovimiento $detalleMovimiento): void
    {
        $this->actualizarStock($detalleMovimiento);
    }

    /**
     * Actualizar stock del producto según tipo de movimiento
     */
    private function actualizarStock($detalle): void
    {
        $producto = Producto::find($detalle->producto_id);
        if (!$producto) return;

        $movimiento = $detalle->movimiento;
        if (!$movimiento) return;

        // Tipo 1 = Entrada (suma), Tipo 2 = Salida (resta)
        if ($movimiento->tipo === 1) {
            $producto->increment('stock_actual', $detalle->cantidad);
        } elseif ($movimiento->tipo === 2) {
            $producto->decrement('stock_actual', $detalle->cantidad);
        }
    }

    /**
     * Revertir stock del producto
     */
    private function revertirStock($detalle): void
    {
        $productoId = is_array($detalle) ? $detalle['producto_id'] : $detalle->producto_id;
        $cantidad = is_array($detalle) ? $detalle['cantidad'] : $detalle->cantidad;
        
        $producto = Producto::find($productoId);
        if (!$producto) return;

        $movimiento = is_array($detalle) ? null : $detalle->movimiento;
        if (!$movimiento) return;

        // Revertir: Entrada resta, Salida suma
        if ($movimiento->tipo === 1) {
            $producto->decrement('stock_actual', $cantidad);
        } elseif ($movimiento->tipo === 2) {
            $producto->increment('stock_actual', $cantidad);
        }
    }
}
