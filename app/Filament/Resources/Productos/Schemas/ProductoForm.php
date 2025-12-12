<?php

namespace App\Filament\Resources\Productos\Schemas;

use App\Models\Categoria;
use App\Models\Unidad;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class ProductoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('categoria_id')
                    ->label('Categoría')
                    ->options(Categoria::all()->pluck('nombre', 'id'))
                    ->required(),
                Select::make('unidad_id')
                    ->label('Unidad de Medida')
                    ->options(Unidad::all()->pluck('nombre', 'id'))
                    ->default(null),
                TextInput::make('nombre')
                    ->label('Nombre del Producto')
                    ->required()
                    ->maxLength(255),
                TextInput::make('codigo')
                    ->label('Código (SKU)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('precio_compra')
                    ->label('Precio de Compra')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('precio_venta')
                    ->label('Precio de Venta')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('stock_minimo')
                    ->label('Stock Mínimo')
                    ->required()
                    ->numeric()
                    ->default(10),
                TextInput::make('stock_actual')
                    ->label('Stock Actual')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->disabled(),
                TextInput::make('tasa_impuesto')
                    ->label('Tasa de Impuesto (%)')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->suffix('%'),
                Toggle::make('impuesto_incluido')
                    ->label('Impuesto Incluido en el Precio')
                    ->default(false)
                    ->required(),
                Toggle::make('estado')
                    ->label('Activo')
                    ->default(true)
                    ->required(),
                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->rows(3)
                    ->columnSpanFull(),
                FileUpload::make('fotos')
                    ->label('Fotos del Producto')
                    ->directory('productos')
                    ->multiple()
                    ->reorderable()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])
                    ->columnSpanFull(),
            ]);
    }
}
