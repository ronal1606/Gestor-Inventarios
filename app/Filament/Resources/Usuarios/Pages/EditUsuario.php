<?php

namespace App\Filament\Resources\Usuarios\Pages;

use App\Filament\Resources\Usuarios\UsuarioResource;
use App\Filament\ResourceAuthorization;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditUsuario extends EditRecord
{
    protected static string $resource = UsuarioResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Editar Usuario: ' . $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        $actions = [];

        // Solo Admin puede eliminar usuarios
        if (ResourceAuthorization::canDelete('usuarios')) {
            $actions[] = DeleteAction::make();
        }

        return $actions;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
