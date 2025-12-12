<?php

namespace App\Filament;

use Illuminate\Support\Facades\Auth;

class ResourceAuthorization
{
    /**
     * Permisos por rol y recurso
     * Formato: 'rol' => ['recurso' => ['action1', 'action2'], ...]
     */
    protected static array $permissions = [
        'Administrador' => [
            'categorias' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'productos' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'clientes' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'proveedores' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'almacenes' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'unidades' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'movimientos' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'ajustes' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'listas-precios' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'metodo-pagos' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'roles' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
            'usuarios' => ['viewAny', 'view', 'create', 'update', 'delete', 'deleteAny'],
        ],
        'Cajero' => [
            'categorias' => ['viewAny', 'view'],
            'productos' => ['viewAny', 'view'],
            'clientes' => ['viewAny', 'view', 'create', 'update'],
            'movimientos' => ['viewAny', 'view', 'create', 'update'],
            'listas-precios' => ['viewAny', 'view'],
            'metodo-pagos' => ['viewAny', 'view'],
        ],
        'Almacenero' => [
            'categorias' => ['viewAny', 'view', 'create', 'update'],
            'productos' => ['viewAny', 'view', 'create', 'update'],
            'almacenes' => ['viewAny', 'view', 'create', 'update'],
            'unidades' => ['viewAny', 'view', 'create', 'update'],
            'proveedores' => ['viewAny', 'view', 'create', 'update'],
            'movimientos' => ['viewAny', 'view', 'create'],
            'ajustes' => ['viewAny', 'view', 'create', 'update'],
        ],
    ];

    /**
     * Verificar si el usuario actual tiene permiso para una acción en un recurso
     */
    public static function can(string $resource, string $action = 'viewAny'): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        $role = $user->rol?->nombre ?? 'Usuario';
        $permissions = self::$permissions[$role] ?? [];
        $resourcePermissions = $permissions[$resource] ?? [];

        return in_array($action, $resourcePermissions);
    }

    /**
     * Verificar si puede ver el recurso
     */
    public static function canView(string $resource): bool
    {
        return self::can($resource, 'viewAny');
    }

    /**
     * Verificar si puede crear
     */
    public static function canCreate(string $resource): bool
    {
        return self::can($resource, 'create');
    }

    /**
     * Verificar si puede editar
     */
    public static function canUpdate(string $resource): bool
    {
        return self::can($resource, 'update');
    }

    /**
     * Verificar si puede eliminar
     */
    public static function canDelete(string $resource): bool
    {
        return self::can($resource, 'delete');
    }

    /**
     * Obtener rol del usuario actual
     */
    public static function getUserRole(): ?string
    {
        return Auth::user()?->rol?->nombre;
    }

    /**
     * Verificar si es admin
     */
    public static function isAdmin(): bool
    {
        return self::getUserRole() === 'Administrador';
    }
}
