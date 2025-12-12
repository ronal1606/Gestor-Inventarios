<div class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900">📦 Crear Entrada de Compra</h2>
        <p class="text-gray-600">Registra nuevos productos y compras del proveedor</p>
    </div>

    <!-- Mensajes -->
    @if ($errorMessage)
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
            {{ $errorMessage }}
        </div>
    @endif

    @if ($successMessage)
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            {{ $successMessage }}
        </div>
    @endif

    <div class="grid grid-cols-3 gap-6">
        <!-- Columna Principal (2/3) -->
        <div class="col-span-2 space-y-6">

            <!-- Información de Entrada -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">📋 Información de Entrada</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Almacén *</label>
                        <select wire:model="almacen_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">-- Selecciona almacén --</option>
                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proveedor *</label>
                        <select wire:model="proveedor_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="">-- Selecciona proveedor --</option>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Factura #</label>
                        <input type="text" wire:model="numero_factura" placeholder="Ej: FAC-001" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                        <input type="datetime-local" wire:model="fecha" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>
                </div>
            </div>

            <!-- Agregar Productos -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">🛒 Agregar Productos</h2>
                    <button wire:click="toggleNuevoProducto" class="px-4 py-2 {{ $crearNuevoProducto ? 'bg-gray-500' : 'bg-blue-500' }} text-white rounded-md hover:opacity-90">
                        {{ $crearNuevoProducto ? '❌ Cancelar' : '✨ Nuevo Producto' }}
                    </button>
                </div>

                @if (!$crearNuevoProducto)
                    <!-- Agregar Producto Existente -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-5 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                                <select wire:model="producto_existente_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                    <option value="">-- Selecciona producto --</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">P. Compra $</label>
                                <input type="number" wire:model="nuevo_producto_precio_compra" step="0.01" min="0" placeholder="Precio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">P. Venta $</label>
                                <input type="number" wire:model="nuevo_producto_precio_venta" step="0.01" min="0" placeholder="Precio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                                <input type="number" wire:model="cantidad_entrada" min="1" placeholder="Ej: 10" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            </div>

                            <div class="flex items-end">
                                <button wire:click="agregarProductoExistente" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed" class="w-full px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                    <span wire:loading.remove>➕ Agregar</span>
                                    <span wire:loading>Agregando...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Crear Nuevo Producto -->
                    <div class="space-y-4 bg-blue-50 p-4 rounded-md">
                        <h3 class="font-semibold text-blue-900">Datos del Nuevo Producto</h3>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                                <input type="text" wire:model="nuevo_producto_nombre" placeholder="Ej: Tornillo 1/4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                                <div class="flex gap-2">
                                    <select wire:model="nueva_categoria_id" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                        <option value="">-- Selecciona o crea --</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" wire:model="nueva_categoria_nombre" placeholder="Nueva..." class="w-24 px-3 py-2 border border-gray-300 rounded-md text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Unidad</label>
                                <div class="flex gap-2">
                                    <select wire:model="nueva_unidad_id" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                        <option value="">-- Selecciona o crea --</option>
                                        @foreach ($unidades as $unidad)
                                            <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" wire:model="nueva_unidad_nombre" placeholder="Nueva..." class="w-24 px-3 py-2 border border-gray-300 rounded-md text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio Compra *</label>
                                <input type="number" wire:model="nuevo_producto_precio_compra" step="0.01" min="0" placeholder="0.00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio Venta *</label>
                                <input type="number" wire:model="nuevo_producto_precio_venta" step="0.01" min="0" placeholder="0.00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">% Impuesto</label>
                                <input type="number" wire:model="nuevo_producto_tasa_impuesto" step="0.01" min="0" max="100" placeholder="0.00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad *</label>
                                <input type="number" wire:model="cantidad_entrada" min="1" placeholder="Ej: 50" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            </div>
                        </div>

                        <button wire:click="crearProductoYAgregar" class="w-full px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 font-semibold">
                            ✅ Crear y Agregar al Carrito
                        </button>
                    </div>
                @endif
            </div>

            <!-- Carrito -->
            @if (!empty($carrito))
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">📦 Productos en Compra</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Producto</th>
                                    <th class="px-4 py-2 text-right">P. Compra</th>
                                    <th class="px-4 py-2 text-right">P. Venta</th>
                                    <th class="px-4 py-2 text-center">Cantidad</th>
                                    <th class="px-4 py-2 text-right">Subtotal</th>
                                    <th class="px-4 py-2 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carrito as $key => $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $item['nombre'] }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <input type="number" 
                                                wire:change="actualizarPrecio('{{ $key }}', $event.target.value)" 
                                                value="{{ $item['precio_compra'] }}"
                                                step="0.01"
                                                min="0" 
                                                class="w-24 px-2 py-1 border border-gray-300 rounded-md text-right">
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            <input type="number" 
                                                wire:change="actualizarPrecioVenta('{{ $key }}', $event.target.value)" 
                                                value="{{ $item['precio_venta'] }}"
                                                step="0.01"
                                                min="0" 
                                                class="w-24 px-2 py-1 border border-gray-300 rounded-md text-right">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="number" 
                                                wire:change="actualizarCantidad('{{ $key }}', $event.target.value)" 
                                                value="{{ $item['cantidad'] }}"
                                                min="1" 
                                                class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center">
                                        </td>
                                        <td class="px-4 py-2 text-right font-semibold">${{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <button wire:click="eliminarProducto('{{ $key }}')" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                                🗑️
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Notas -->
            <div class="bg-white p-6 rounded-lg shadow">
                <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                <textarea wire:model="notas" placeholder="Notas sobre la compra..." rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500"></textarea>
            </div>

        </div>

        <!-- Columna Lateral (1/3) - Resumen -->
        <div class="col-span-1">
            <div class="bg-white p-6 rounded-lg shadow sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Resumen</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Productos:</span>
                        <span class="font-semibold">{{ count($carrito) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Cantidad:</span>
                        <span class="font-semibold">{{ collect($carrito)->sum('cantidad') }}</span>
                    </div>

                    <hr>

                    <div class="flex justify-between text-lg">
                        <span class="font-bold text-gray-800">Total:</span>
                        <span class="font-bold text-cyan-600">${{ number_format($total, 0, ',', '.') }} COP</span>
                    </div>

                    @if (!empty($carrito))
                        <button wire:click="guardarEntrada" 
                            wire:loading.attr="disabled" 
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            :disabled="$procesando"
                            class="w-full mt-4 px-4 py-3 bg-green-500 text-white rounded-md hover:bg-green-600 font-bold disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="guardarEntrada">✅ Guardar Entrada</span>
                            <span wire:loading wire:target="guardarEntrada">Guardando...</span>
                        </button>
                    @else
                        <div class="w-full mt-4 px-4 py-3 bg-gray-300 text-gray-600 rounded-md text-center font-semibold">
                            Agrega productos
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
