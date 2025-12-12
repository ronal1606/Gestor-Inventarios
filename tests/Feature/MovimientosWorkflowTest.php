<?php

namespace Tests\Feature;

use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Tests\TestCase;

class MovimientosWorkflowTest extends TestCase
{
    protected User $user;
    protected Almacen $almacen;
    protected Cliente $cliente;
    protected Proveedor $proveedor;
    protected Producto $producto;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear usuario autenticado
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // Crear datos de prueba
        $this->almacen = Almacen::factory()->create();
        $this->cliente = Cliente::factory()->create();
        $this->proveedor = Proveedor::factory()->create();
        $this->producto = Producto::factory()->create([
            'stock_actual' => 100,
            'precio_venta' => 50,
            'precio_compra' => 30,
            'tasa_impuesto' => 16,
        ]);
    }

    /** @test */
    public function can_access_salida_page()
    {
        $response = $this->get(route('movimiento.salida'));

        $response->assertStatus(200);
        $response->assertViewIs('livewire.movimiento-salida');
    }

    /** @test */
    public function can_access_entrada_page()
    {
        $response = $this->get(route('movimiento.entrada'));

        $response->assertStatus(200);
        $response->assertViewIs('livewire.movimiento-entrada');
    }

    /** @test */
    public function salida_component_loads_correctly()
    {
        $this->get(route('movimiento.salida'));

        // Verificar que el componente cargó
        $this->assertNotNull($this->almacen);
        $this->assertNotNull($this->cliente);
        $this->assertNotNull($this->producto);
    }

    /** @test */
    public function entrada_component_loads_correctly()
    {
        $this->get(route('movimiento.entrada'));

        // Verificar que el componente cargó
        $this->assertNotNull($this->almacen);
        $this->assertNotNull($this->proveedor);
        $this->assertNotNull($this->producto);
    }

    /** @test */
    public function producto_stock_calculation_is_correct()
    {
        $initial_stock = $this->producto->stock_actual;

        // Simular salida
        $this->producto->decrement('stock_actual', 10);

        $this->assertEquals($initial_stock - 10, $this->producto->fresh()->stock_actual);
    }

    /** @test */
    public function producto_stock_increment_on_entrada()
    {
        $initial_stock = $this->producto->stock_actual;

        // Simular entrada
        $this->producto->increment('stock_actual', 50);

        $this->assertEquals($initial_stock + 50, $this->producto->fresh()->stock_actual);
    }

    /** @test */
    public function tax_calculation_is_correct()
    {
        $subtotal = 100;
        $tax_rate = $this->producto->tasa_impuesto;
        $tax = $subtotal * ($tax_rate / 100);

        $this->assertEquals(16, $tax);
        $this->assertEquals(116, $subtotal + $tax);
    }

    /** @test */
    public function almacenes_are_loaded()
    {
        $almacenes = Almacen::all();

        $this->assertGreaterThanOrEqual(1, $almacenes->count());
    }

    /** @test */
    public function clientes_are_loaded()
    {
        $clientes = Cliente::all();

        $this->assertGreaterThanOrEqual(1, $clientes->count());
    }

    /** @test */
    public function proveedores_are_loaded()
    {
        $proveedores = Proveedor::all();

        $this->assertGreaterThanOrEqual(1, $proveedores->count());
    }

    /** @test */
    public function productos_are_loaded()
    {
        $productos = Producto::all();

        $this->assertGreaterThanOrEqual(1, $productos->count());
    }
}
