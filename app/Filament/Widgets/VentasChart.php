<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VentasChart extends ChartWidget
{
    protected ?string $heading = '📊 Ventas de los últimos 7 días';
    
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        // Obtener ventas de los últimos 7 días agrupadas por día
        $ventas = Movimiento::select(
            DB::raw('DATE(fecha) as fecha'),
            DB::raw('SUM(monto_total) as total')
        )
        ->where('tipo', 2) // Solo ventas (tipo 2 = salida)
        ->whereBetween('fecha', [now()->subDays(7), now()])
        ->groupBy(DB::raw('DATE(fecha)'))
        ->orderBy('fecha')
        ->get();

        // Crear array de últimos 7 días
        $ultimos7dias = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = now()->subDays($i)->format('Y-m-d');
            $ultimos7dias[$fecha] = 0;
        }

        // Llenar con datos reales
        foreach ($ventas as $venta) {
                $fecha_formateada = \Illuminate\Support\Carbon::parse($venta->fecha)->format('Y-m-d');
                $ultimos7dias[$fecha_formateada] = (float) $venta->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ventas ($)',
                    'data' => array_values($ultimos7dias),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => array_map(
                fn ($fecha) => Carbon::parse($fecha)->format('d/m'),
                array_keys($ultimos7dias)
            ),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
