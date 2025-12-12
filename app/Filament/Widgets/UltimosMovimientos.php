<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimosMovimientos extends BaseWidget
{
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Movimiento::query()
                    ->with(['cliente', 'proveedor', 'usuario', 'almacen'])
                    ->orderBy('fecha', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (int $state): string => $state === 1 ? 'Entrada' : 'Salida')
                    ->color(fn (int $state): string => $state === 1 ? 'success' : 'info'),
                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->label('Cliente')
                    ->default('—')
                    ->searchable(),
                Tables\Columns\TextColumn::make('proveedor.nombre')
                    ->label('Proveedor')
                    ->default('—')
                    ->searchable(),
                Tables\Columns\TextColumn::make('numero_factura')
                    ->label('Factura')
                    ->default('—')
                    ->searchable(),
                Tables\Columns\TextColumn::make('monto_total')
                    ->label('Monto Total')
                    ->money('COP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('usuario.name')
                    ->label('Usuario')
                    ->default('—'),
            ])
            ->heading('📋 Últimos Movimientos')
            ->defaultPaginationPageOption(5);
    }
}
