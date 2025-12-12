<?php

namespace App\Livewire;

use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\DetalleMovimiento;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Unidad;
use Livewire\Component;

class MovimientoEntrada extends Component
{
    // Datos del movimiento
    public ?int $almacen_id = null;
    public ?int $proveedor_id = null;
    public ?string $numero_factura = null;
    public ?string $fecha = null;
    public string $notas = '';

    // Para crear nuevo producto
    public bool $crearNuevoProducto = false;
    public ?int $producto_existente_id = null;
    public string $nuevo_producto_nombre = '';
    public ?int $nueva_categoria_id = null;
    public string $nueva_categoria_nombre = '';
    public ?int $nueva_unidad_id = null;
    public string $nueva_unidad_nombre = '';
    public float $nuevo_producto_precio_compra = 0;
    public float $nuevo_producto_precio_venta = 0;
    public float $nuevo_producto_tasa_impuesto = 0;

    // Carrito
    public array $carrito = [];
    public ?int $cantidad_entrada = null;

    // Estados
    public string $errorMessage = '';
    public string $successMessage = '';
    public bool $procesando = false;

    public function mount()
    {
        $this->fecha = now()->format('Y-m-d\TH:i');
    }

    #[\Livewire\Attributes\Computed]
    public function almacenes()
    {
        return Almacen::orderBy('nombre')->get();
    }

    #[\Livewire\Attributes\Computed]
    public function proveedores()
    {
        return Proveedor::orderBy('nombre')->get();
    }

    #[\Livewire\Attributes\Computed]
    public function productos()
    {
        return Producto::orderBy('nombre')->get();
    }

    #[\Livewire\Attributes\Computed]
    public function categorias()
    {
        return Categoria::orderBy('nombre')->get();
    }

    #[\Livewire\Attributes\Computed]
    public function unidades()
    {
        return Unidad::orderBy('nombre')->get();
    }

    #[\Livewire\Attributes\Computed]
    public function total()
    {
        return collect($this->carrito)->sum(fn($item) => $item['subtotal'] ?? 0);
    }

    public function toggleNuevoProducto()
    {
        $this->crearNuevoProducto = !$this->crearNuevoProducto;
        if (!$this->crearNuevoProducto) {
            $this->resetProductoFields();
        }
    }

    private function resetProductoFields()
    {
        $this->producto_existente_id = null;
        $this->nuevo_producto_nombre = '';
        $this->nueva_categoria_id = null;
        $this->nueva_categoria_nombre = '';
        $this->nueva_unidad_id = null;
        $this->nueva_unidad_nombre = '';
        $this->nuevo_producto_precio_compra = 0;
        $this->nuevo_producto_precio_venta = 0;
        $this->nuevo_producto_tasa_impuesto = 0;
    }

    public function crearProductoYAgregar()
    {
        $this->errorMessage = '';

        if (!$this->nuevo_producto_nombre) {
            $this->errorMessage = 'El nombre del producto es requerido';
            return;
        }

        if ($this->nuevo_producto_precio_compra <= 0 || $this->nuevo_producto_precio_venta <= 0) {
            $this->errorMessage = 'Los precios deben ser mayores a 0';
            return;
        }

        if (!$this->cantidad_entrada || $this->cantidad_entrada <= 0) {
            $this->errorMessage = 'Cantidad debe ser mayor a 0';
            return;
        }

        try {
            // Crear categoría si es nueva
            if ($this->nueva_categoria_nombre && !$this->nueva_categoria_id) {
                $categoria = Categoria::create(['nombre' => $this->nueva_categoria_nombre]);
                $this->nueva_categoria_id = $categoria->id;
            }

            // Crear unidad si es nueva
            if ($this->nueva_unidad_nombre && !$this->nueva_unidad_id) {
                $unidad = Unidad::create(['nombre' => $this->nueva_unidad_nombre]);
                $this->nueva_unidad_id = $unidad->id;
            }

            // Crear producto con código generado automáticamente
            $codigoBase = strtoupper(substr($this->nuevo_producto_nombre, 0, 3));
            $ultimoProducto = Producto::where('codigo', 'like', $codigoBase . '%')->orderBy('codigo', 'desc')->first();
            $numero = 1;
            if ($ultimoProducto) {
                $ultimoCodigo = $ultimoProducto->codigo;
                preg_match('/(\d+)$/', $ultimoCodigo, $matches);
                if ($matches) {
                    $numero = (int)$matches[1] + 1;
                }
            }
            $codigo = $codigoBase . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);

            $producto = Producto::create([
                'nombre' => $this->nuevo_producto_nombre,
                'codigo' => $codigo,
                'categoria_id' => $this->nueva_categoria_id,
                'unidad_id' => $this->nueva_unidad_id,
                'precio_compra' => $this->nuevo_producto_precio_compra,
                'precio_venta' => $this->nuevo_producto_precio_venta,
                'tasa_impuesto' => $this->nuevo_producto_tasa_impuesto,
                'stock_actual' => 0,
                'stock_minimo' => 10,
                'estado' => true,
            ]);

            // Agregar al carrito
            $this->agregarProductoAlCarrito($producto->id);
            $this->crearNuevoProducto = false;
            $this->resetProductoFields();
            $this->cantidad_entrada = null;

        } catch (\Exception $e) {
            $this->errorMessage = 'Error al crear producto: ' . $e->getMessage();
        }
    }

    public function updatedProductoExistenteId($value)
    {
        // Cuando selecciones un producto, autocompleta el precio actual
        if ($value) {
            $producto = Producto::find($value);
            if ($producto) {
                // Usa el precio actual del producto como sugerencia, pero permite cambiarlo
                $this->nuevo_producto_precio_compra = $producto->precio_compra;
                $this->nuevo_producto_precio_venta = $producto->precio_venta;
            }
        } else {
            $this->nuevo_producto_precio_compra = 0;
            $this->nuevo_producto_precio_venta = 0;
        }
    }

    public function agregarProductoExistente()
    {
        $this->errorMessage = '';

        if (!$this->producto_existente_id) {
            $this->errorMessage = 'Selecciona un producto';
            return;
        }

        if (!$this->cantidad_entrada || $this->cantidad_entrada <= 0) {
            $this->errorMessage = 'Cantidad debe ser mayor a 0';
            return;
        }

        if ($this->nuevo_producto_precio_compra <= 0) {
            $this->errorMessage = 'El precio de compra debe ser mayor a 0';
            return;
        }

        // El precio que escribiste en el formulario se usa tal como está
        $this->agregarProductoAlCarrito($this->producto_existente_id);
        $this->producto_existente_id = null;
        $this->cantidad_entrada = null;
        $this->nuevo_producto_precio_compra = 0;
        $this->nuevo_producto_precio_venta = 0;
    }

    private function agregarProductoAlCarrito($producto_id)
    {
        $producto = Producto::find($producto_id);
        if (!$producto) {
            $this->errorMessage = 'Producto no encontrado';
            return;
        }

        // Determinar precios: si viene de crear nuevo producto, usar los nuevos precios; si no, usar los del producto existente
        $precioCompra = $this->nuevo_producto_precio_compra > 0 ? $this->nuevo_producto_precio_compra : $producto->precio_compra;
        $precioVenta = $this->nuevo_producto_precio_venta > 0 ? $this->nuevo_producto_precio_venta : $producto->precio_venta;
        
        $key = $producto_id;

        // SIEMPRE REEMPLAZAR, no sumar (evita duplicados)
        $this->carrito[$key] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'cantidad' => $this->cantidad_entrada,
            'precio_compra' => $precioCompra,
            'precio_venta' => $precioVenta,
            'subtotal' => $precioCompra * $this->cantidad_entrada,
        ];

        $this->recalcularSubtotal($key);
    }

    public function recalcularSubtotal($key)
    {
        if (isset($this->carrito[$key])) {
            $this->carrito[$key]['subtotal'] = $this->carrito[$key]['precio_compra'] * $this->carrito[$key]['cantidad'];
        }
    }

    public function actualizarCantidad($key, $nuevaCantidad)
    {
        if ($nuevaCantidad <= 0) {
            $this->eliminarProducto($key);
        } else {
            $this->carrito[$key]['cantidad'] = $nuevaCantidad;
            $this->recalcularSubtotal($key);
        }
    }

    public function actualizarPrecio($key, $nuevoPrecio)
    {
        if (isset($this->carrito[$key])) {
            $this->carrito[$key]['precio_compra'] = $nuevoPrecio;
            $this->recalcularSubtotal($key);
        }
    }

    public function actualizarPrecioVenta($key, $nuevoPrecio)
    {
        if (isset($this->carrito[$key])) {
            $this->carrito[$key]['precio_venta'] = $nuevoPrecio;
        }
    }

    public function eliminarProducto($key)
    {
        unset($this->carrito[$key]);
    }

    public function guardarEntrada()
    {
        if ($this->procesando) {
            return; // Ya se está procesando
        }
        
        $this->procesando = true;
        $this->errorMessage = '';

        if (empty($this->carrito)) {
            $this->errorMessage = 'El carrito está vacío';
            $this->procesando = false;
            return;
        }

        if (!$this->almacen_id || !$this->proveedor_id) {
            $this->errorMessage = 'Selecciona almacén y proveedor';
            $this->procesando = false;
            return;
        }

        try {
            $movimiento = Movimiento::create([
                'tipo' => 1, // Entrada
                'almacen_id' => $this->almacen_id,
                'proveedor_id' => $this->proveedor_id,
                'usuario_id' => auth()->id(),
                'monto_total' => $this->total(),
                'fecha' => $this->fecha,
                'numero_factura' => $this->numero_factura,
                'notas' => $this->notas,
            ]);

            foreach ($this->carrito as $item) {
                DetalleMovimiento::create([
                    'movimiento_id' => $movimiento->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_compra'],
                    'subtotal' => $item['subtotal'],
                    'monto_impuesto' => 0,
                ]);

                // Actualizar solo precios (el stock se actualiza automáticamente via observer)
                $producto = Producto::find($item['id']);
                $producto->update([
                    'precio_compra' => $item['precio_compra'],
                    'precio_venta' => $item['precio_venta'],
                ]);
            }

            $this->successMessage = '✅ Entrada registrada correctamente. ID: ' . $movimiento->id;
            $this->carrito = [];
            $this->almacen_id = null;
            $this->proveedor_id = null;
            $this->numero_factura = null;
            $this->notas = '';
            $this->procesando = false;

        } catch (\Exception $e) {
            $this->errorMessage = 'Error: ' . $e->getMessage();
            $this->procesando = false;
        }
    }

    public function render()
    {
        return view('livewire.movimiento-entrada', [
            'almacenes' => $this->almacenes,
            'proveedores' => $this->proveedores,
            'productos' => $this->productos,
            'categorias' => $this->categorias,
            'unidades' => $this->unidades,
            'total' => $this->total,
        ])->layout('layouts.app');
    }
}
