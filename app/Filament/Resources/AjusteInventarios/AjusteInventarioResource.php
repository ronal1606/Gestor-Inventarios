<?php

namespace App\Filament\Resources\AjusteInventarios;

use App\Filament\Resources\AjusteInventarios\Pages\CreateAjusteInventario;
use App\Filament\Resources\AjusteInventarios\Pages\EditAjusteInventario;
use App\Filament\Resources\AjusteInventarios\Pages\ListAjusteInventarios;
use App\Filament\Resources\AjusteInventarios\Schemas\AjusteInventarioForm;
use App\Filament\Resources\AjusteInventarios\Tables\AjusteInventariosTable;
use App\Models\AjusteInventario;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AjusteInventarioResource extends Resource
{
    protected static ?string $model = AjusteInventario::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrench;

    protected static ?string $modelLabel = 'Ajuste de Inventario';
    protected static ?string $pluralModelLabel = 'Ajustes de Inventario';
    protected static ?string $navigationLabel = 'Ajustes';
    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return AjusteInventarioForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AjusteInventariosTable::configure($table);
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
            'index' => ListAjusteInventarios::route('/'),
            'create' => CreateAjusteInventario::route('/create'),
            'edit' => EditAjusteInventario::route('/{record}/edit'),
        ];
    }
}
