<?php

namespace App\Filament\Traits;

use App\Filament\ResourceAuthorization;
use Illuminate\Database\Eloquent\Model;

trait WithResourceAuthorization
{
    /**
     * Nombre del recurso para autorización (ej: 'productos', 'categorias')
     */
    abstract protected static function getResourceName(): string;

    /**
     * Verificar si el usuario puede ver este recurso
     */
    public static function canViewAny(): bool
    {
        return ResourceAuthorization::canView(static::getResourceName());
    }

    /**
     * Verificar si el usuario puede crear registros
     */
    public static function canCreate(): bool
    {
        return ResourceAuthorization::canCreate(static::getResourceName());
    }

    /**
     * Verificar si el usuario puede editar este registro
     */
    public static function canEdit(Model $record): bool
    {
        return ResourceAuthorization::canUpdate(static::getResourceName());
    }

    /**
     * Verificar si el usuario puede eliminar este registro
     */
    public static function canDelete(Model $record): bool
    {
        return ResourceAuthorization::canDelete(static::getResourceName());
    }

    /**
     * Verificar si el usuario puede ver múltiples registros
     */
    public static function canDeleteAny(): bool
    {
        return ResourceAuthorization::canDelete(static::getResourceName());
    }
}
