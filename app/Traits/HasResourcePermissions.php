<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasResourcePermissions
{
    /**
     * Obtener el rol del usuario actual
     */
    public static function getUserRole(): ?string
    {
        return Auth::user()?->rol?->nombre;
    }

    /**
     * Verificar si el usuario es Administrador
     */
    public static function isAdmin(): bool
    {
        return self::getUserRole() === 'Administrador';
    }

    /**
     * Verificar si el usuario es Cajero
     */
    public static function isCajero(): bool
    {
        return self::getUserRole() === 'Cajero';
    }

    /**
     * Verificar si el usuario es Almacenero
     */
    public static function isAlmacenero(): bool
    {
        return self::getUserRole() === 'Almacenero';
    }

    /**
     * Verificar si un usuario puede ver un recurso
     */
    public static function canViewResource(string $resource): bool
    {
        $role = self::getUserRole();

        $permissions = [
            'Administrador' => ['all'], // Admin ve todo
            'Cajero' => ['categorias', 'productos', 'clientes', 'movimientos', 'metodo-pagos', 'listas-precios'],
            'Almacenero' => ['categorias', 'productos', 'almacenes', 'stocks', 'proveedores', 'ajustes-inventario', 'unidades'],
        ];

        if (isset($permissions[$role])) {
            return in_array('all', $permissions[$role]) || in_array($resource, $permissions[$role]);
        }

        return false;
    }

    /**
     * Verificar si un usuario puede crear un registro
     */
    public static function canCreate(): bool
    {
        $role = self::getUserRole();
        return $role === 'Administrador' || $role === 'Almacenero' || $role === 'Cajero';
    }

    /**
     * Verificar si un usuario puede editar un registro
     */
    public static function canEdit(): bool
    {
        $role = self::getUserRole();
        return $role === 'Administrador' || $role === 'Almacenero';
    }

    /**
     * Verificar si un usuario puede eliminar un registro
     */
    public static function canDelete(): bool
    {
        $role = self::getUserRole();
        return $role === 'Administrador';
    }
}
