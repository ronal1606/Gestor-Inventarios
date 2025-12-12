<?php

namespace App\Filament\Resources\Usuarios\Schemas;

use App\Models\Rol;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UsuarioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nombre Completo')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->dehydrateStateUsing(function (?string $state) {
                        if (!$state) {
                            return null; // Si está vacío, no enviar nada
                        }
                        return bcrypt($state);
                    })
                    ->required(fn (string $operation) => $operation === 'create')
                    ->nullable()
                    ->helperText(fn (string $operation) => $operation === 'edit' ? 'Dejar vacío para no cambiar la contraseña' : 'Ingresa una contraseña')
                    ->maxLength(255),
                Select::make('rol_id')
                    ->label('Rol')
                    ->options(Rol::all()->pluck('nombre', 'id'))
                    ->required(),
            ]);
    }
}
