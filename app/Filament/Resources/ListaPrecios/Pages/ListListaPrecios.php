<?php

namespace App\Filament\Resources\ListaPrecios\Pages;

use App\Filament\Resources\ListaPrecios\ListaPreciosResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListListaPrecios extends ListRecords
{
    protected static string $resource = ListaPreciosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
