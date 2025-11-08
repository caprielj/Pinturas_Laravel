<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('precios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_presentacion_id')
                ->constrained('productopresentacion')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('sucursal_id')
                ->nullable()
                ->constrained('sucursales')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->decimal('precio_venta', 12, 2);
            $table->decimal('descuento_pct', 5, 2)->default(0);
            $table->dateTime('vigente_desde')->useCurrent();
            $table->dateTime('vigente_hasta')->nullable();
            $table->boolean('activo')->default(true);

            // Índices
            $table->index('producto_presentacion_id', 'idx_precios_producto_presentacion');
            $table->index('sucursal_id', 'idx_precios_sucursal');
            $table->index(['vigente_desde', 'vigente_hasta'], 'idx_precios_vigencia');
            $table->index('activo', 'idx_precios_activo');
            $table->index(['producto_presentacion_id', 'sucursal_id', 'vigente_desde'], 'idx_precios_consulta');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `precios` COMMENT 'Precios de productos por sucursal con vigencia temporal'");
    }

    public function down(): void
    {
        Schema::dropIfExists('precios');
    }
};
