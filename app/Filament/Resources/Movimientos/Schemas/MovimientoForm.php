<?php

namespace App\Filament\Resources\Movimientos\Schemas;

use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class MovimientoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // TIPO DE MOVIMIENTO
                Select::make('tipo')
                    ->label('Tipo de Movimiento')
                    ->options([
                        1 => ' ENTRADA (Compra a Proveedor)',
                        2 => ' SALIDA (Venta a Cliente)',
                    ])
                    ->required()
                    ->live()
                    ->native(false),

                // ALMACÉN
                Select::make('almacen_id')
                    ->relationship('almacen', 'nombre')
                    ->label('Almacén')
                    ->required()
                    ->native(false),

                // PROVEEDOR (solo entrada)
                Select::make('proveedor_id')
                    ->relationship('proveedor', 'nombre')
                    ->label('Proveedor')
                    ->visible(fn (Get $get) => $get('tipo') === '1' || $get('tipo') === 1)
                    ->nullable()
                    ->native(false),

                // CLIENTE (solo salida)
                Select::make('cliente_id')
                    ->relationship('cliente', 'nombre')
                    ->label('Cliente')
                    ->visible(fn (Get $get) => $get('tipo') === '2' || $get('tipo') === 2)
                    ->nullable()
                    ->native(false),

                // VENDEDOR / RESPONSABLE
                Select::make('usuario_id')
                    ->relationship('usuario', 'name')
                    ->label('Vendedor / Responsable')
                    ->required()
                    ->native(false),

                // NÚMERO DE FACTURA
                TextInput::make('numero_factura')
                    ->label('Número de Factura')
                    ->placeholder('Ej: FV-001')
                    ->nullable(),

                // FECHA Y HORA
                DateTimePicker::make('fecha')
                    ->label('Fecha y Hora')
                    ->default(now())
                    ->required(),

                // TOTAL
                TextInput::make('monto_total')
                    ->label('Total del Movimiento')
                    ->numeric()
                    ->prefix('$')
                    ->disabled()
                    ->dehydrated()
                    ->default(0)
                    ->columnSpanFull(),

                // NOTAS
                Textarea::make('notas')
                    ->label('Notas Internas')
                    ->rows(3)
                    ->placeholder('Escribe aquí notas sobre este movimiento...')
                    ->columnSpanFull(),
            ]);
    }
}
