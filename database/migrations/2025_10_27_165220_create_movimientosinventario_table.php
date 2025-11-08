<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientosinventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')
                ->constrained('sucursales')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('producto_presentacion_id')
                ->constrained('productopresentacion')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->string('tipo', 20);
            $table->integer('cantidad');
            $table->string('referencia', 60)->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Índices
            $table->index('sucursal_id', 'idx_movimientos_sucursal');
            $table->index('producto_presentacion_id', 'idx_movimientos_producto');
            $table->index('tipo', 'idx_movimientos_tipo');
            $table->index('created_at', 'idx_movimientos_fecha');
            $table->index(['sucursal_id', 'tipo', 'created_at'], 'idx_movimientos_consulta');
            $table->index(['producto_presentacion_id', 'created_at'], 'idx_movimientos_producto_fecha');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `movimientosinventario` COMMENT 'Historial de movimientos de inventario'");
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientosinventario');
    }
};
