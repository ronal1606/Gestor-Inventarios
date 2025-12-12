<?php

namespace App\Livewire;

use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\DetalleMovimiento;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Unidad;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;

class MovimientoSalida extends Component
{
    // Datos del movimiento
    public ?int $almacen_id = null;
    public ?int $cliente_id = null;
    public ?string $numero_factura = null;
    public ?string $fecha = null;
    public string $notas = '';

    // Carrito
    public array $carrito = [];
    public ?int $producto_busqueda_id = null;
    public ?int $cantidad = null;

    // Estados
    public string $errorMessage = '';
    public string $successMessage = '';
    public bool $mostrarFormulario = false;
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
    public function clientes()
    {
        return Cliente::orderBy('nombre')->get();
    }

    #[\Livewire\Attributes\Computed]
    public function productos()
    {
        return Producto::where('estado', true)
            ->orderBy('nombre')
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'nombre' => $p->nombre,
                'precio_venta' => $p->precio_venta,
                'stock' => $p->stock_actual,
            ]);
    }

    #[\Livewire\Attributes\Computed]
    public function total()
    {
        return collect($this->carrito)->sum(fn($item) => $item['subtotal'] ?? 0);
    }

    #[\Livewire\Attributes\Computed]
    public function impuesto()
    {
        return collect($this->carrito)->sum(fn($item) => $item['impuesto'] ?? 0);
    }

    public function agregarProducto()
    {
        $this->errorMessage = '';

        if (!$this->producto_busqueda_id) {
            $this->errorMessage = 'Selecciona un producto';
            return;
        }

        if (!$this->cantidad || $this->cantidad <= 0) {
            $this->errorMessage = 'Cantidad debe ser mayor a 0';
            return;
        }

        $producto = Producto::find($this->producto_busqueda_id);
        if (!$producto) {
            $this->errorMessage = 'Producto no encontrado';
            return;
        }

        if ($producto->stock_actual < $this->cantidad) {
            $this->errorMessage = "Stock insuficiente. Disponible: {$producto->stock_actual}";
            return;
        }

        $key = $this->producto_busqueda_id;
        $subtotal = $producto->precio_venta * $this->cantidad;
        $impuesto = $subtotal * ($producto->tasa_impuesto / 100);

        // SIEMPRE REEMPLAZAR, no sumar (evita duplicados)
        $this->carrito[$key] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $producto->precio_venta,
            'tasa_impuesto' => $producto->tasa_impuesto,
            'subtotal' => $subtotal,
            'impuesto' => $impuesto,
        ];

        $this->recalcularSubtotal($key);
        $this->producto_busqueda_id = null;
        $this->cantidad = null;
    }

    public function recalcularSubtotal($key)
    {
        if (isset($this->carrito[$key])) {
            $subtotal = $this->carrito[$key]['precio_unitario'] * $this->carrito[$key]['cantidad'];
            $impuesto = $subtotal * ($this->carrito[$key]['tasa_impuesto'] / 100);
            $this->carrito[$key]['subtotal'] = $subtotal;
            $this->carrito[$key]['impuesto'] = $impuesto;
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

    public function eliminarProducto($key)
    {
        unset($this->carrito[$key]);
    }

    public function guardarVenta()
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

        if (!$this->almacen_id || !$this->cliente_id) {
            $this->errorMessage = 'Selecciona almacén y cliente';
            $this->procesando = false;
            return;
        }

        try {
            $movimiento = Movimiento::create([
                'tipo' => 2, // Salida
                'almacen_id' => $this->almacen_id,
                'cliente_id' => $this->cliente_id,
                'usuario_id' => auth()->id(),
                'monto_total' => $this->total() + $this->impuesto(),
                'fecha' => $this->fecha,
                'numero_factura' => $this->numero_factura,
                'notas' => $this->notas,
            ]);

            foreach ($this->carrito as $item) {
                DetalleMovimiento::create([
                    'movimiento_id' => $movimiento->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['subtotal'],
                    'monto_impuesto' => $item['impuesto'],
                ]);
                // El stock se actualiza automáticamente via observer
            }

            $this->successMessage = '✅ Venta registrada correctamente. ID: ' . $movimiento->id;
            $this->carrito = [];
            $this->almacen_id = null;
            $this->cliente_id = null;
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
        return view('livewire.movimiento-salida', [
            'almacenes' => $this->almacenes,
            'clientes' => $this->clientes,
            'productos' => $this->productos,
            'total' => $this->total,
            'impuesto' => $this->impuesto,
        ])->layout('layouts.app');
    }
}
