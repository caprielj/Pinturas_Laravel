<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventariosucursal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')
                ->constrained('sucursales')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('producto_presentacion_id')
                ->constrained('productopresentacion')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('existencia')->default(0);
            $table->integer('minimo')->default(0);

            // Índice único para evitar duplicados
            $table->unique(['sucursal_id', 'producto_presentacion_id'], 'unique_sucursal_producto');

            // Índices adicionales
            $table->index('sucursal_id', 'idx_inventario_sucursal');
            $table->index('producto_presentacion_id', 'idx_inventario_producto_presentacion');
            $table->index('existencia', 'idx_inventario_existencia');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `inventariosucursal` COMMENT 'Control de inventario por sucursal y producto-presentación'");
    }

    public function down(): void
    {
        Schema::dropIfExists('inventariosucursal');
    }
};
