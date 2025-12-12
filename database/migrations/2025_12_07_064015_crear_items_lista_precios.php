<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items_lista_precios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lista_precios_id')->constrained('listas_precios')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->decimal('precio', 10, 2);
            $table->timestamps();
            $table->unique(['lista_precios_id', 'producto_id']);
            $table->index('producto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items_lista_precios');
    }
};
