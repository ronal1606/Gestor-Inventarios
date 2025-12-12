<?php

namespace App\Filament\Resources\ListaPrecios;

use App\Filament\Resources\ListaPrecios\Pages\CreateListaPrecios;
use App\Filament\Resources\ListaPrecios\Pages\EditListaPrecios;
use App\Filament\Resources\ListaPrecios\Pages\ListListaPrecios;
use App\Filament\Resources\ListaPrecios\Schemas\ListaPreciosForm;
use App\Filament\Resources\ListaPrecios\Tables\ListaPreciosTable;
use App\Models\ListaPrecios;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ListaPreciosResource extends Resource
{
    protected static ?string $model = ListaPrecios::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $modelLabel = 'Lista de Precios';
    protected static ?string $pluralModelLabel = 'Listas de Precios';
    protected static ?string $navigationLabel = 'Listas Precios';
    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema
    {
        return ListaPreciosForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ListaPreciosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListListaPrecios::route('/'),
            'create' => CreateListaPrecios::route('/create'),
            'edit' => EditListaPrecios::route('/{record}/edit'),
        ];
    }
}
