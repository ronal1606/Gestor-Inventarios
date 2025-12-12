<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Movimiento;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $totalProductos = Producto::count();
        $totalClientes = Cliente::where('estado', 1)->count();
        $stockTotal = Producto::sum('stock_actual');
        $stockBajo = Producto::whereColumn('stock_actual', '<=', 'stock_minimo')->count();
        
        $ventasHoy = Movimiento::where('tipo', 2)
            ->whereDate('fecha', today())
            ->sum('monto_total');
            
        $ventasMesActual = Movimiento::where('tipo', 2)
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('monto_total');
            
        $ventasMesAnterior = Movimiento::where('tipo', 2)
            ->whereMonth('fecha', now()->subMonth()->month)
            ->whereYear('fecha', now()->subMonth()->year)
            ->sum('monto_total');
            
        $cambioVentas = $ventasMesAnterior > 0 
            ? round((($ventasMesActual - $ventasMesAnterior) / $ventasMesAnterior) * 100, 1)
            : 0;

        return [
            Stat::make('Ventas del Mes', '$' . number_format($ventasMesActual, 2))
                ->description($cambioVentas >= 0 ? "+{$cambioVentas}% vs mes anterior" : "{$cambioVentas}% vs mes anterior")
                ->descriptionIcon($cambioVentas >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($cambioVentas >= 0 ? 'success' : 'danger')
                ->chart([12, 18, 25, 30, 35, 40, 45]),
                
            Stat::make('Ventas Hoy', '$' . number_format($ventasHoy, 2))
                ->description('Total de ventas del día')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([5, 10, 15, 20, 25, 30, 35]),
                
            Stat::make('Stock Total', number_format($stockTotal) . ' unidades')
                ->description($stockBajo > 0 ? "{$stockBajo} productos con stock bajo" : 'Stock saludable')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color($stockBajo > 0 ? 'warning' : 'success')
                ->chart([100, 95, 90, 88, 85, 83, 80]),
                
            Stat::make('Total Productos', $totalProductos)
                ->description('Productos registrados')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info')
                ->chart([50, 55, 58, 60, 62, 64, 65]),
        ];
    }
}
