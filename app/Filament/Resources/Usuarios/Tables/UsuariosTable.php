<?php

namespace App\Filament\Resources\Usuarios\Tables;

use App\Filament\ResourceAuthorization;
use App\Filament\Resources\Usuarios\UsuarioResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class UsuariosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => ResourceAuthorization::canUpdate('usuarios') 
                        ? UsuarioResource::getUrl('edit', ['record' => $record->id])
                        : null),
                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rol.nombre')
                    ->label('Rol')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Administrador' => 'danger',
                        'Cajero' => 'warning',
                        'Almacenero' => 'info',
                        'Vendedor' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('id')
                    ->label('Acciones')
                    ->formatStateUsing(fn ($record) => ResourceAuthorization::canUpdate('usuarios') ? '✎ Editar' : '')
                    ->url(fn ($record) => ResourceAuthorization::canUpdate('usuarios') 
                        ? UsuarioResource::getUrl('edit', ['record' => $record->id])
                        : null)
                    ->openUrlInNewTab(false)
                    ->color('info'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->paginated([10, 25, 50]);
    }
}


