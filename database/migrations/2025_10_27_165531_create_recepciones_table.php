<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recepciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_compra_id')->constrained('ordenes_compra')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('sucursal_id')->constrained('sucursales')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('usuario_id')->constrained('usuarios')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamp('fecha_recepcion')->useCurrent();
            $table->text('observaciones')->nullable();

            $table->index('orden_compra_id', 'idx_recepcion_orden');
            $table->index('sucursal_id', 'idx_recepcion_sucursal');
            $table->index('usuario_id', 'idx_recepcion_usuario');
            $table->index('fecha_recepcion', 'idx_recepcion_fecha');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `recepciones` COMMENT 'Recepciones de productos de órdenes de compra'");
    }

    public function down(): void
    {
        Schema::dropIfExists('recepciones');
    }
};
