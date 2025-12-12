<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sección Búsqueda de Productos -->
        <div class="lg:col-span-2">
            <x-filament::section>
                <x-slot name="heading">
                    🔍 Seleccionar Productos
                </x-slot>

                <div class="space-y-4">
                    <!-- Almacén y Cliente -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Almacén</label>
                            <select wire:model="almacen_id" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                <option value="">-- Seleccionar --</option>
                                @foreach ($this->almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente</label>
                            <select wire:model="cliente_id" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                <option value="">-- Seleccionar --</option>
                                @foreach ($this->clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="my-4" />

                    <!-- Búsqueda de Producto -->
                    <div class="grid grid-cols-2 gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Producto</label>
                            <select wire:model="producto_id" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-cyan-500">
                                <option value="">-- Buscar Producto --</option>
                                @foreach ($this->productos as $producto)
                                    <option value="{{ $producto->id }}">
                                        {{ $producto->nombre }} - ${{ number_format($producto->precio_venta, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input type="number" wire:model="cantidad" min="1" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                        </div>
                    </div>

                    <!-- Botón Agregar -->
                    <button wire:click="agregarAlCarrito" class="w-full bg-cyan-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-cyan-700 transition">
                        ➕ Agregar al Carrito
                    </button>

                    @if ($errors->has('cantidad') || $errors->has('producto_id'))
                        <div class="text-red-600 text-sm">
                            {{ $errors->first('cantidad') ?? $errors->first('producto_id') }}
                        </div>
                    @endif
                </div>
            </x-filament::section>

            <!-- Carrito de Compra -->
            <x-filament::section class="mt-6">
                <x-slot name="heading">
                    🛒 Carrito de Compra
                </x-slot>

                @if (empty($this->carrito))
                    <div class="text-center py-8 text-gray-500">
                        Carrito vacío. Selecciona productos para comenzar.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">Producto</th>
                                    <th class="px-4 py-2 text-center text-sm font-semibold">Cant.</th>
                                    <th class="px-4 py-2 text-right text-sm font-semibold">Precio</th>
                                    <th class="px-4 py-2 text-right text-sm font-semibold">Subtotal</th>
                                    <th class="px-4 py-2 text-center text-sm font-semibold">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($this->carrito as $key => $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $item['nombre'] }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <input type="number" value="{{ $item['cantidad'] }}" min="1"
                                                wire:change="actualizarCantidad({{ $key }}, $event.target.value)"
                                                class="w-16 rounded border border-gray-300 px-2 py-1 text-center">
                                        </td>
                                        <td class="px-4 py-2 text-right">${{ number_format($item['precio_unitario'], 2) }}</td>
                                        <td class="px-4 py-2 text-right font-medium">${{ number_format($item['subtotal'], 2) }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <button wire:click="eliminarDelCarrito({{ $key }})" class="text-red-600 hover:text-red-800 font-bold">
                                                ✕
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-filament::section>
        </div>

        <!-- Resumen de Venta -->
        <div>
            <x-filament::section>
                <x-slot name="heading">
                    💰 Resumen
                </x-slot>

                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span>Productos:</span>
                        <span class="font-semibold">{{ count($this->carrito) }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span>Cantidad Total:</span>
                        <span class="font-semibold">{{ collect($this->carrito)->sum('cantidad') }}</span>
                    </div>

                    <hr class="my-4" />

                    <div class="flex justify-between text-lg font-bold text-cyan-600">
                        <span>Total:</span>
                        <span>${{ number_format($this->total, 2) }}</span>
                    </div>

                    <button wire:click="completarVenta" 
                        {{ empty($this->carrito) ? 'disabled' : '' }}
                        class="w-full {{ empty($this->carrito) ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-3 rounded-lg font-bold transition mt-6">
                        ✅ Completar Venta
                    </button>

                    @if ($errors->has('carrito') || $errors->has('cliente_id') || $errors->has('general'))
                        <div class="text-red-600 text-sm mt-4 p-3 bg-red-50 rounded">
                            {{ $errors->first('carrito') ?? $errors->first('cliente_id') ?? $errors->first('general') }}
                        </div>
                    @endif
                </div>
            </x-filament::section>

            <!-- Vendedor -->
            <x-filament::section class="mt-6">
                <x-slot name="heading">
                    👤 Vendedor
                </x-slot>

                <div class="text-center py-4">
                    <p class="text-lg font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-600">ID: {{ auth()->id() }}</p>
                </div>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
