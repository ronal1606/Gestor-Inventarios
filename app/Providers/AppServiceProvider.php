<?php

namespace App\Providers;

use App\Models\DetalleMovimiento;
use App\Models\AjusteInventario;
use App\Observers\DetalleMovimientoObserver;
use App\Observers\AjusteInventarioObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- IMPRESCINDIBLE

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
        // Tus observadores (NO LOS BORRES)
        DetalleMovimiento::observe(DetalleMovimientoObserver::class);
        AjusteInventario::observe(AjusteInventarioObserver::class);

        // CODIGO DE FUERZA BRUTA PARA HTTPS
        // (Sin if, sin preguntas, forzado directo)
        URL::forceScheme('https');
    }
}
