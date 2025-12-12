<?php

namespace Database\Seeders;

use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Unidad;
use App\Models\ListaPrecios;
use App\Models\ItemListaPrecios;
use App\Models\MetodoPago;
use Illuminate\Database\Seeder;

class DatosProuebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear unidades
        $unidades = [
            ['nombre' => 'Kilogramo', 'simbolo' => 'kg', 'factor_base' => 1, 'es_predeterminada' => true],
            ['nombre' => 'Litro', 'simbolo' => 'lt', 'factor_base' => 1, 'es_predeterminada' => false],
            ['nombre' => 'Pieza', 'simbolo' => 'pz', 'factor_base' => 1, 'es_predeterminada' => false],
            ['nombre' => 'Metro', 'simbolo' => 'm', 'factor_base' => 1, 'es_predeterminada' => false],
        ];

        foreach ($unidades as $unidad) {
            Unidad::firstOrCreate(
                ['nombre' => $unidad['nombre']],
                $unidad
            );
        }

        // Crear categorías
        $categorias = [
            ['nombre' => 'Ferretería General', 'descripcion' => 'Artículos generales de ferretería', 'estado' => 1],
            ['nombre' => 'Herrajes', 'descripcion' => 'Cerraduras, bisagras y accesorios', 'estado' => 1],
            ['nombre' => 'Pintura', 'descripcion' => 'Pinturas y barnices', 'estado' => 1],
            ['nombre' => 'Tuberías', 'descripcion' => 'Tuberías de PVC y metal', 'estado' => 1],
            ['nombre' => 'Herramientas', 'descripcion' => 'Herramientas manuales y eléctricas', 'estado' => 1],
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(
                ['nombre' => $categoria['nombre']],
                $categoria
            );
        }

        // Crear almacenes
        $almacenes = [
            ['nombre' => 'Almacén Principal', 'direccion' => 'Calle Principal 123', 'es_predeterminado' => true],
            ['nombre' => 'Almacén Secundario', 'direccion' => 'Avenida Central 456', 'es_predeterminado' => false],
        ];

        foreach ($almacenes as $almacen) {
            Almacen::firstOrCreate(
                ['nombre' => $almacen['nombre']],
                $almacen
            );
        }

        // Crear proveedores
        $proveedores = [
            ['nombre' => 'Distribuidor X', 'telefono' => '123456789', 'email' => 'distribuidor@example.com', 'direccion' => 'Calle 1', 'estado' => 1],
            ['nombre' => 'Fabricante Y', 'telefono' => '987654321', 'email' => 'fabricante@example.com', 'direccion' => 'Calle 2', 'estado' => 1],
        ];

        foreach ($proveedores as $proveedor) {
            Proveedor::firstOrCreate(
                ['nombre' => $proveedor['nombre']],
                $proveedor
            );
        }

        // Crear listas de precios
        $listas = [
            ['nombre' => 'Precio Minorista', 'descripcion' => 'Precios para clientes minoristas', 'es_predeterminada' => true, 'estado' => 1],
            ['nombre' => 'Precio Mayorista', 'descripcion' => 'Precios para clientes mayoristas con descuento', 'es_predeterminada' => false, 'estado' => 1],
        ];

        foreach ($listas as $lista) {
            ListaPrecios::firstOrCreate(
                ['nombre' => $lista['nombre']],
                $lista
            );
        }

        // Crear clientes
        $clientes = [
            ['nombre' => 'Juan García', 'email' => 'juan@example.com', 'telefono' => '111111111', 'direccion' => 'Avenida 1', 'estado' => 1, 'lista_precios_id' => 1],
            ['nombre' => 'María López', 'email' => 'maria@example.com', 'telefono' => '222222222', 'direccion' => 'Avenida 2', 'estado' => 1, 'lista_precios_id' => 1],
            ['nombre' => 'Carlos Construcciones', 'email' => 'carlos@construction.com', 'telefono' => '333333333', 'direccion' => 'Calle Construcción', 'estado' => 1, 'lista_precios_id' => 2],
        ];

        foreach ($clientes as $cliente) {
            Cliente::firstOrCreate(
                ['email' => $cliente['email']],
                $cliente
            );
        }

        // Crear métodos de pago
        $metodos = [
            ['nombre' => 'Efectivo', 'requiere_referencia' => false, 'estado' => 1],
            ['nombre' => 'Tarjeta de Crédito', 'requiere_referencia' => true, 'estado' => 1],
            ['nombre' => 'Transferencia Bancaria', 'requiere_referencia' => true, 'estado' => 1],
            ['nombre' => 'Cheque', 'requiere_referencia' => true, 'estado' => 1],
        ];

        foreach ($metodos as $metodo) {
            MetodoPago::firstOrCreate(
                ['nombre' => $metodo['nombre']],
                $metodo
            );
        }

        // Crear productos
        $productos = [
            [
                'categoria_id' => 1,
                'nombre' => 'Clavo de Acero 3"',
                'codigo' => 'CLAVO-3',
                'descripcion' => 'Clavo de acero de 3 pulgadas, resistente',
                'precio_compra' => 0.50,
                'precio_venta' => 1.00,
                'stock_minimo' => 100,
                'stock_actual' => 500,
                'unidad_id' => 3,
                'tasa_impuesto' => 0,
                'impuesto_incluido' => false,
                'estado' => 1,
            ],
            [
                'categoria_id' => 3,
                'nombre' => 'Pintura Blanca 1L',
                'codigo' => 'PINTURA-B-1L',
                'descripcion' => 'Pintura blanca de buena calidad, cubrimiento 10m²/L',
                'precio_compra' => 8.00,
                'precio_venta' => 15.00,
                'stock_minimo' => 20,
                'stock_actual' => 60,
                'unidad_id' => 2,
                'tasa_impuesto' => 5,
                'impuesto_incluido' => false,
                'estado' => 1,
            ],
            [
                'categoria_id' => 4,
                'nombre' => 'Tubo PVC 1/2"',
                'codigo' => 'TUBOPVC-05',
                'descripcion' => 'Tubo de PVC de 1/2 pulgada, resistente a presión',
                'precio_compra' => 2.00,
                'precio_venta' => 4.50,
                'stock_minimo' => 50,
                'stock_actual' => 150,
                'unidad_id' => 4,
                'tasa_impuesto' => 0,
                'impuesto_incluido' => false,
                'estado' => 1,
            ],
        ];

        foreach ($productos as $producto) {
            Producto::firstOrCreate(
                ['codigo' => $producto['codigo']],
                $producto
            );
        }
    }
}
