<?php

namespace App\Filament\Resources\AjusteInventarios\Pages;

use App\Filament\Resources\AjusteInventarios\AjusteInventarioResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAjusteInventario extends CreateRecord
{
    protected static string $resource = AjusteInventarioResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
