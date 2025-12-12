<?php

namespace App\Observers;

use App\Models\AjusteInventario;
use App\Models\Producto;

class AjusteInventarioObserver
{
    /**
     * Handle the AjusteInventario "created" event.
     */
    public function created(AjusteInventario $ajusteInventario): void
    {
        $this->aplicarAjuste($ajusteInventario);
    }

    /**
     * Aplicar ajuste al stock del producto
     */
    private function aplicarAjuste(AjusteInventario $ajuste): void
    {
        $producto = Producto::find($ajuste->producto_id);
        if (!$producto) return;

        // diferencia_qty puede ser positivo o negativo
        $producto->stock_actual += $ajuste->diferencia_qty;
        $producto->save();
    }
}
