<?php

namespace App\Observers;

use App\Models\Movimiento;

class MovimientoObserver
{
    /**
     * Handle the Movimiento "created" event.
     */
    public function created(Movimiento $movimiento): void
    {
        //
    }

    /**
     * Handle the Movimiento "updated" event.
     */
    public function updated(Movimiento $movimiento): void
    {
        //
    }

    /**
     * Handle the Movimiento "deleted" event.
     */
    public function deleted(Movimiento $movimiento): void
    {
        //
    }

    /**
     * Handle the Movimiento "restored" event.
     */
    public function restored(Movimiento $movimiento): void
    {
        //
    }

    /**
     * Handle the Movimiento "force deleted" event.
     */
    public function forceDeleted(Movimiento $movimiento): void
    {
        //
    }
}
