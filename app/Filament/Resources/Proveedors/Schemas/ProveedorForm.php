<?php

namespace App\Filament\Resources\Proveedors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProveedorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del Proveedor')
                    ->required()
                    ->maxLength(255),
                TextInput::make('telefono')
                    ->label('Teléfono')
                    ->tel()
                    ->default(null),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->default(null),
                Textarea::make('direccion')
                    ->label('Dirección')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('estado')
                    ->label('Activo')
                    ->default(true)
                    ->required(),
            ]);
    }
}
