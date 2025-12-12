<?php

namespace App\Filament\Resources\ListaPrecios\Pages;

use App\Filament\Resources\ListaPrecios\ListaPreciosResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditListaPrecios extends EditRecord
{
    protected static string $resource = ListaPreciosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

