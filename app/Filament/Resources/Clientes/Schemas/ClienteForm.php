<?php

namespace App\Filament\Resources\Clientes\Schemas;

use App\Models\ListaPrecios;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ClienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del Cliente')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->default(null),
                TextInput::make('telefono')
                    ->label('Teléfono')
                    ->tel()
                    ->default(null),
                Select::make('lista_precios_id')
                    ->label('Lista de Precios')
                    ->options(ListaPrecios::where('estado', 1)->pluck('nombre', 'id'))
                    ->default(null)
                    ->helperText('Selecciona una lista de precios personalizada para este cliente'),
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
