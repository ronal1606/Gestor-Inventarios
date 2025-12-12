<?php

namespace App\Filament\Resources\Productos\Tables;

use App\Filament\ResourceAuthorization;
use App\Filament\Resources\Productos\ProductoResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->sortable(),
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => ResourceAuthorization::canUpdate('productos')
                        ? ProductoResource::getUrl('edit', ['record' => $record->id])
                        : null),
                TextColumn::make('codigo')
                    ->label('Código')
                    ->searchable(),
                TextColumn::make('precio_compra')
                    ->label('Precio Compra')
                    ->money('COP')
                    ->sortable(),
                TextColumn::make('precio_venta')
                    ->label('Precio Venta')
                    ->money('COP')
                    ->sortable(),
                TextColumn::make('stock_minimo')
                    ->label('Stock Mínimo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_actual')
                    ->label('Stock Actual')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unidad.nombre')
                    ->label('Unidad')
                    ->sortable(),
                TextColumn::make('tasa_impuesto')
                    ->label('Impuesto %')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('impuesto_incluido')
                    ->label('Incluye Impuesto')
                    ->boolean(),
                TextColumn::make('estado')
                    ->label('Estado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ]);
    }
}

