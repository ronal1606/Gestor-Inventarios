<?php

namespace App\Filament\Resources\AjusteInventarios\Schemas;

use App\Models\Almacen;
use App\Models\Producto;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AjusteInventarioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('almacen_id')
                    ->label('Almacén')
                    ->options(Almacen::all()->pluck('nombre', 'id'))
                    ->required(),
                Select::make('producto_id')
                    ->label('Producto')
                    ->options(Producto::all()->pluck('nombre', 'id'))
                    ->required(),
                TextInput::make('diferencia_qty')
                    ->label('Diferencia de Cantidad')
                    ->numeric()
                    ->required()
                    ->helperText('Positivo para agregar, negativo para restar'),
                Textarea::make('motivo')
                    ->label('Motivo del Ajuste')
                    ->rows(2)
                    ->required(),
                Textarea::make('notas')
                    ->label('Notas Adicionales')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }
}
