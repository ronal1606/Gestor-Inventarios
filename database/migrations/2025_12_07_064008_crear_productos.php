<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->integer('stock_minimo')->default(10);
            $table->integer('stock_actual')->default(0);
            $table->foreignId('unidad_id')->nullable()->constrained('unidades')->nullOnDelete();
            $table->decimal('tasa_impuesto', 5, 2)->default(0);
            $table->boolean('impuesto_incluido')->default(false);
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
            $table->index(['categoria_id', 'estado']);
            $table->index('codigo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
