<?php

namespace App\Filament\Resources\Usuarios\Pages;

use App\Filament\Resources\Usuarios\UsuarioResource;
use App\Filament\ResourceAuthorization;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsuarios extends ListRecords
{
    protected static string $resource = UsuarioResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        // Solo Admin y Almacenero pueden crear usuarios
        if (ResourceAuthorization::canCreate('usuarios')) {
            $actions[] = Actions\CreateAction::make();
        }

        return $actions;
    }
}
