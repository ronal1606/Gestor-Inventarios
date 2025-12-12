<?php

namespace App\Filament\Resources\Movimientos;

use App\Filament\Resources\Movimientos\Pages\CreateMovimiento;
use App\Filament\Resources\Movimientos\Pages\EditMovimiento;
use App\Filament\Resources\Movimientos\Pages\ListMovimientos;
use App\Filament\Resources\Movimientos\Schemas\MovimientoForm;
use App\Filament\Resources\Movimientos\Tables\MovimientosTable;
use App\Filament\ResourceAuthorization;
use App\Models\Movimiento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MovimientoResource extends Resource
{
    protected static ?string $model = Movimiento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static ?string $modelLabel = 'Movimiento';
    protected static ?string $pluralModelLabel = 'Movimientos';
    protected static ?string $navigationLabel = 'Movimientos';
    protected static ?int $navigationSort = 7;

    public static function canViewAny(): bool
    {
        return ResourceAuthorization::canView('movimientos');
    }

    public static function canCreate(): bool
    {
        return ResourceAuthorization::canCreate('movimientos');
    }

    public static function canEdit(Model $record): bool
    {
        return ResourceAuthorization::canUpdate('movimientos');
    }

    public static function canDelete(Model $record): bool
    {
        return ResourceAuthorization::canDelete('movimientos');
    }

    public static function form(Schema $schema): Schema
    {
        return MovimientoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MovimientosTable::configure($table);
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
            'index' => ListMovimientos::route('/'),
            'create' => CreateMovimiento::route('/create'),
            'edit' => EditMovimiento::route('/{record}/edit'),
        ];
    }
}
