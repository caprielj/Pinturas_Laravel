<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_compra', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('serie', 10)->default('OC');
            $table->foreignId('proveedor_id')->constrained('proveedores')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('sucursal_id')->constrained('sucursales')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('usuario_id')->constrained('usuarios')->onUpdate('cascade')->onDelete('restrict');
            $table->date('fecha_orden');
            $table->date('fecha_entrega_estimada')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('estado', ['PENDIENTE', 'PARCIAL', 'RECIBIDA', 'CANCELADA'])->default('PENDIENTE');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['numero', 'serie'], 'unique_orden');
            $table->index('proveedor_id', 'idx_ordenes_proveedor');
            $table->index('sucursal_id', 'idx_ordenes_sucursal');
            $table->index('usuario_id', 'idx_ordenes_usuario');
            $table->index('fecha_orden', 'idx_ordenes_fecha');
            $table->index('estado', 'idx_ordenes_estado');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `ordenes_compra` COMMENT 'Órdenes de compra a proveedores'");
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_compra');
    }
};
