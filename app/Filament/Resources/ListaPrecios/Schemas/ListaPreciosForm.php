<?php

namespace App\Filament\Resources\ListaPrecios\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ListaPreciosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre de la Lista')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Ej: Mayorista, Minorista, VIP, Especial'),
                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->rows(2)
                    ->helperText('Describe para qué clientes o situaciones se usa esta lista de precios'),
                Toggle::make('es_predeterminada')
                    ->label('Lista Predeterminada')
                    ->helperText('Esta será la lista de precios por defecto para nuevos clientes')
                    ->default(false),
                Toggle::make('estado')
                    ->label('Activa')
                    ->default(true)
                    ->required(),
            ]);
    }
}
