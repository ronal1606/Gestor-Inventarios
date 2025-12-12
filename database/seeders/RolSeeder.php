<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Acceso completo al sistema. Puede gestionar usuarios, roles, configuraciones y todos los módulos.',
            ],
            [
                'nombre' => 'Cajero',
                'descripcion' => 'Puede registrar ventas, crear movimientos de salida, ver reportes de ventas y gestionar clientes.',
            ],
            [
                'nombre' => 'Almacenero',
                'descripcion' => 'Puede gestionar el inventario, realizar entradas de compras, ajustes de stock y ver stocks disponibles.',
            ],
        ];

        foreach ($roles as $rol) {
            Rol::firstOrCreate(['nombre' => $rol['nombre']], $rol);
        }
    }
}
