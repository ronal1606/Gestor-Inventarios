<?php

namespace App\Filament\Resources\Unidads\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UnidadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre de la Unidad')
                    ->required()
                    ->maxLength(255),
                TextInput::make('simbolo')
                    ->label('Símbolo (ej: kg, lt, pz)')
                    ->required()
                    ->maxLength(50),
                TextInput::make('factor_base')
                    ->label('Factor Base')
                    ->numeric()
                    ->default(1)
                    ->required(),
                Toggle::make('es_predeterminada')
                    ->label('Unidad Predeterminada')
                    ->default(false),
            ]);
    }
}
