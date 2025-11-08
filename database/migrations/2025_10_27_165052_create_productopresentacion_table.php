<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productopresentacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('presentacion_id')
                ->constrained('presentaciones')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->boolean('activo')->default(true);

            // Índice único para evitar duplicados
            $table->unique(['producto_id', 'presentacion_id'], 'unique_producto_presentacion');

            // Índices adicionales
            $table->index('producto_id', 'idx_pp_producto');
            $table->index('presentacion_id', 'idx_pp_presentacion');
            $table->index('activo', 'idx_pp_activo');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `productopresentacion` COMMENT 'Relaciona productos con sus presentaciones disponibles para venta'");
    }

    public function down(): void
    {
        Schema::dropIfExists('productopresentacion');
    }
};
