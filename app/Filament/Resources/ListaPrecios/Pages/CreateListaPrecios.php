<?php

namespace App\Filament\Resources\ListaPrecios\Pages;

use App\Filament\Resources\ListaPrecios\ListaPreciosResource;
use Filament\Resources\Pages\CreateRecord;

class CreateListaPrecios extends CreateRecord
{
    protected static string $resource = ListaPreciosResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
