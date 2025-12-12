<?php

namespace App\Filament\Resources\Movimientos\Pages;

use App\Filament\Resources\Movimientos\MovimientoResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMovimientos extends ListRecords
{
    protected static string $resource = MovimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('salida')
                ->label('📤 Nueva Salida')
                ->url(route('movimiento.salida'))
                ->color('success')
                ->icon('heroicon-o-arrow-up-on-square'),

            Action::make('entrada')
                ->label('📥 Nueva Entrada')
                ->url(route('movimiento.entrada'))
                ->color('info')
                ->icon('heroicon-o-arrow-down-on-square'),
        ];
    }
}
