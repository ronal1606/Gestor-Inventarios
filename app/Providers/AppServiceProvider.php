<?php

namespace App\Providers;

use App\Models\DetalleMovimiento;
use App\Models\AjusteInventario;
use App\Observers\DetalleMovimientoObserver;
use App\Observers\AjusteInventarioObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DetalleMovimiento::observe(DetalleMovimientoObserver::class);
        AjusteInventario::observe(AjusteInventarioObserver::class);
    }
}
