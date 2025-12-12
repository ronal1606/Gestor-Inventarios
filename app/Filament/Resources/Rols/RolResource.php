<?php

namespace App\Filament\Resources\Rols;

use App\Filament\Resources\Rols\Pages\CreateRol;
use App\Filament\Resources\Rols\Pages\EditRol;
use App\Filament\Resources\Rols\Pages\ListRols;
use App\Filament\Resources\Rols\Schemas\RolForm;
use App\Filament\Resources\Rols\Tables\RolsTable;
use App\Filament\ResourceAuthorization;
use App\Models\Rol;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RolResource extends Resource
{
    protected static ?string $model = Rol::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Rol';
    protected static ?string $pluralModelLabel = 'Roles';
    protected static ?string $navigationLabel = 'Roles';
    protected static ?int $navigationSort = 19;

    public static function canViewAny(): bool
    {
        return ResourceAuthorization::canView('roles');
    }

    public static function canCreate(): bool
    {
        return ResourceAuthorization::canCreate('roles');
    }

    public static function canEdit(Model $record): bool
    {
        return ResourceAuthorization::canUpdate('roles');
    }

    public static function canDelete(Model $record): bool
    {
        return ResourceAuthorization::canDelete('roles');
    }

    public static function form(Schema $schema): Schema
    {
        return RolForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolsTable::configure($table);
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
            'index' => ListRols::route('/'),
            'create' => CreateRol::route('/create'),
            'edit' => EditRol::route('/{record}/edit'),
        ];
    }
}
