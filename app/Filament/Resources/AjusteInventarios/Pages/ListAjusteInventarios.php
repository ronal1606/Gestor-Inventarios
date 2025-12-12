<?php

namespace App\Filament\Resources\AjusteInventarios\Pages;

use App\Filament\Resources\AjusteInventarios\AjusteInventarioResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAjusteInventarios extends ListRecords
{
    protected static string $resource = AjusteInventarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
