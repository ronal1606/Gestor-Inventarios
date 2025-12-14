<?php

namespace App\Providers;

use App\Models\DetalleMovimiento;
use App\Models\AjusteInventario;
use App\Observers\DetalleMovimientoObserver;
use App\Observers\AjusteInventarioObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- AGREGUE ESTA LINEA IMPORTANTE

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
        // 1. TUS OBSERVADORES ORIGINALES (SE QUEDAN QUIETOS)
        DetalleMovimiento::observe(DetalleMovimientoObserver::class);
        AjusteInventario::observe(AjusteInventarioObserver::class);

        // 2. EL CODIGO NUEVO PARA FORZAR HTTPS (SE AGREGA AL FINAL)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
