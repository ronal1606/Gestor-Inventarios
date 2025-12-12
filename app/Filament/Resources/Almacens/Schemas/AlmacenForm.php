<?php

namespace App\Filament\Resources\Almacens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AlmacenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del Almacén')
                    ->required()
                    ->maxLength(255),
                Textarea::make('direccion')
                    ->label('Dirección')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('es_predeterminado')
                    ->label('Almacén Predeterminado')
                    ->default(false),
            ]);
    }
}
