<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('tipo'); // 1 entrada, 2 salida
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores')->nullOnDelete();
            $table->foreignId('almacen_id')->nullable()->constrained('almacenes')->nullOnDelete();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('monto_total', 12, 2)->default(0);
            $table->dateTime('fecha');
            $table->string('numero_factura')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->index(['tipo', 'fecha']);
            $table->index('numero_factura');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
