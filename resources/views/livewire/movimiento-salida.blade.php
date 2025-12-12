<div class="space-y-6 p-6">
    <!-- Título -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900">📤 Registrar Salida (Venta)</h2>
        <p class="text-gray-600">Selecciona productos y crea una venta</p>
    </div>

    <!-- Mensajes -->
    @if($errorMessage)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-red-700 font-semibold">⚠️ {{ $errorMessage }}</p>
        </div>
    @endif

    @if($successMessage)
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-green-700 font-semibold">{{ $successMessage }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sección Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Datos del Movimiento -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">📋 Información del Movimiento</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Almacén</label>
                        <select wire:model="almacen_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500">
                            <option value="">-- Seleccionar --</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cliente</label>
                        <select wire:model="cliente_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500">
                            <option value="">-- Seleccionar --</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Factura</label>
                        <input type="text" wire:model="numero_factura" placeholder="FV-001" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                        <input type="datetime-local" wire:model="fecha" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>

            <!-- Agregar Productos -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">🛍️ Agregar Productos</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Producto</label>
                        <select wire:model="producto_busqueda_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500">
                            <option value="">-- Seleccionar --</option>
                            @foreach($productos as $p)
                                <option value="{{ $p['id'] }}">{{ $p['nombre'] }} (Stock: {{ $p['stock'] }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                        <input type="number" wire:model="cantidad" min="1" placeholder="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="flex items-end">
                        <button wire:click="agregarProducto" class="w-full bg-cyan-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-cyan-700 transition">
                            ➕ Agregar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Carrito -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">🛒 Carrito de Venta</h3>
                
                @if(empty($carrito))
                    <div class="text-center py-8 text-gray-500">
                        Carrito vacío. Agrega productos para comenzar.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">Producto</th>
                                    <th class="px-4 py-2 text-center text-sm font-semibold">Cant.</th>
                                    <th class="px-4 py-2 text-right text-sm font-semibold">Precio Unit.</th>
                                    <th class="px-4 py-2 text-right text-sm font-semibold">Subtotal</th>
                                    <th class="px-4 py-2 text-center text-sm font-semibold">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($carrito as $key => $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $item['nombre'] }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <input type="number" value="{{ $item['cantidad'] }}" min="1"
                                                wire:change="actualizarCantidad({{ $key }}, $event.target.value)"
                                                class="w-16 px-2 py-1 text-center border border-gray-300 rounded">
                                        </td>
                                        <td class="px-4 py-2 text-right">${{ number_format($item['precio_unitario'], 2) }}</td>
                                        <td class="px-4 py-2 text-right font-medium">${{ number_format($item['subtotal'], 2) }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <button wire:click="eliminarProducto({{ $key }})" class="text-red-600 hover:text-red-800 font-bold">✕</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Notas -->
            <div class="bg-white rounded-lg shadow p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Notas Internas</label>
                <textarea wire:model="notas" rows="3" placeholder="Notas sobre esta venta..." class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
            </div>
        </div>

        <!-- Resumen (Sidebar) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-6 space-y-4">
                <h3 class="text-lg font-semibold">💰 Resumen</h3>

                <div class="flex justify-between text-sm">
                    <span>Productos:</span>
                    <span class="font-semibold">{{ count($carrito) }}</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span>Cantidad Total:</span>
                    <span class="font-semibold">{{ collect($carrito)->sum('cantidad') }}</span>
                </div>

                <hr>

                <div class="flex justify-between text-sm">
                    <span>Subtotal:</span>
                    <span class="font-semibold">${{ number_format($total, 0, ',', '.') }} COP</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span>Impuesto:</span>
                    <span class="font-semibold text-orange-600">${{ number_format($impuesto, 0, ',', '.') }} COP</span>
                </div>

                <div class="flex justify-between text-lg font-bold text-cyan-600 pt-2 border-t">
                    <span>Total:</span>
                    <span>${{ number_format($total + $impuesto, 0, ',', '.') }} COP</span>
                </div>

                <button wire:click="guardarVenta" 
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    :disabled="$procesando"
                    {{ empty($carrito) ? 'disabled' : '' }}
                    class="w-full {{ empty($carrito) ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-3 rounded-lg font-bold transition mt-6 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="guardarVenta">✅ Guardar Venta</span>
                    <span wire:loading wire:target="guardarVenta">Guardando...</span>
                </button>

                <button onclick="history.back()" class="w-full bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium hover:bg-gray-400">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
