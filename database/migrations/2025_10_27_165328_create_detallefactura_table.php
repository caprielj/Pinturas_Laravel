<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detallefactura', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')
                ->constrained('facturas')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('producto_presentacion_id')
                ->constrained('productopresentacion')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('descuento_pct_aplicado', 5, 2)->default(0);
            $table->decimal('subtotal', 12, 2);

            // Índices
            $table->index('factura_id', 'idx_detallefactura_factura');
            $table->unique(['factura_id', 'producto_presentacion_id'], 'unique_factura_producto');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        // Agregar constraints de validación
        DB::statement('ALTER TABLE `detallefactura` ADD CONSTRAINT `check_cantidad` CHECK (`cantidad` > 0)');
        DB::statement('ALTER TABLE `detallefactura` ADD CONSTRAINT `check_precio` CHECK (`precio_unitario` >= 0)');

        DB::statement("ALTER TABLE `detallefactura` COMMENT 'Detalle de productos en facturas'");
    }

    public function down(): void
    {
        Schema::dropIfExists('detallefactura');
    }
};
