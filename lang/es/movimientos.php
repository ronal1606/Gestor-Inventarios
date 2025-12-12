<?php

return [
    // Mensajes generales
    'success' => 'Operación realizada exitosamente',
    'error' => 'Error en la operación',
    'warning' => 'Advertencia',
    'info' => 'Información',

    // SALIDA
    'salida' => [
        'titulo' => '📤 Nueva Salida de Productos',
        'descripcion' => 'Registra las ventas y despachos de productos',
        'crear_exitoso' => '✅ Salida registrada correctamente. ID: ',
        'stock_insuficiente' => 'Stock insuficiente. Disponible: ',
        'carrito_vacio' => 'El carrito está vacío',
        'campos_requeridos' => 'Selecciona almacén y cliente',
        'productos_titulo' => '🛒 Seleccionar Productos',
        'carrito_titulo' => '📦 Productos en Salida',
        'resumen_titulo' => '📊 Resumen de Venta',
        'cantidad_requerida' => 'Cantidad debe ser mayor a 0',
        'producto_no_encontrado' => 'Producto no encontrado',
    ],

    // ENTRADA
    'entrada' => [
        'titulo' => '📥 Nueva Entrada de Compra',
        'descripcion' => 'Registra las compras de proveedores',
        'crear_exitoso' => '✅ Entrada registrada correctamente. ID: ',
        'carrito_vacio' => 'El carrito está vacío',
        'campos_requeridos' => 'Selecciona almacén y proveedor',
        'productos_titulo' => '🛒 Agregar Productos',
        'carrito_titulo' => '📦 Productos en Compra',
        'resumen_titulo' => '📊 Resumen de Compra',
        'nuevo_producto_titulo' => 'Datos del Nuevo Producto',
        'nombre_requerido' => 'El nombre del producto es requerido',
        'precios_requeridos' => 'Los precios deben ser mayores a 0',
        'cantidad_requerida' => 'Cantidad debe ser mayor a 0',
        'error_crear_producto' => 'Error al crear producto: ',
        'nuevo_producto_btn' => '✨ Nuevo Producto',
        'cancelar_btn' => '❌ Cancelar',
        'crear_agregar_btn' => '✅ Crear y Agregar al Carrito',
        'producto_no_encontrado' => 'Producto no encontrado',
    ],

    // Campos comunes
    'almacen_label' => 'Almacén *',
    'almacen_placeholder' => '-- Selecciona almacén --',
    'cliente_label' => 'Cliente *',
    'cliente_placeholder' => '-- Selecciona cliente --',
    'proveedor_label' => 'Proveedor *',
    'proveedor_placeholder' => '-- Selecciona proveedor --',
    'producto_label' => 'Producto',
    'producto_placeholder' => '-- Selecciona producto --',
    'cantidad_label' => 'Cantidad',
    'cantidad_placeholder' => 'Ej: 10',
    'factura_label' => 'Factura #',
    'factura_placeholder' => 'Ej: FAC-001',
    'fecha_label' => 'Fecha',
    'notas_label' => 'Notas',
    'notas_placeholder' => 'Notas sobre la transacción...',

    // Botones
    'agregar_btn' => '➕ Agregar',
    'guardar_btn' => '✅ Guardar',
    'eliminar_btn' => '🗑️ Eliminar',
    'cancelar_btn' => '❌ Cancelar',

    // Resumen
    'cantidad_productos' => 'Productos:',
    'total_cantidad' => 'Total Cantidad:',
    'subtotal' => 'Subtotal:',
    'impuesto' => 'Impuesto:',
    'total' => 'Total:',

    // Validaciones
    'validar_stock' => 'Verificando stock...',
    'stock_ok' => 'Stock disponible',
    'stock_bajo' => 'Stock bajo - última oportunidad',
    'sin_stock' => 'Sin stock',
];
