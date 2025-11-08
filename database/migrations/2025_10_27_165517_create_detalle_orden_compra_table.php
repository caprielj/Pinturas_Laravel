<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_orden_compra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_compra_id')->constrained('ordenes_compra')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('producto_presentacion_id')->constrained('productopresentacion')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('descuento_pct', 5, 2)->default(0);
            $table->decimal('subtotal', 12, 2);
            $table->integer('cantidad_recibida')->default(0);

            $table->index('orden_compra_id', 'idx_detalle_orden');
            $table->index('producto_presentacion_id', 'idx_detalle_producto_pres');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement('ALTER TABLE `detalle_orden_compra` ADD CONSTRAINT `check_cantidad_oc` CHECK (`cantidad` > 0)');
        DB::statement('ALTER TABLE `detalle_orden_compra` ADD CONSTRAINT `check_precio_oc` CHECK (`precio_unitario` >= 0)');
        DB::statement('ALTER TABLE `detalle_orden_compra` ADD CONSTRAINT `check_desc_oc` CHECK (`descuento_pct` >= 0 AND `descuento_pct` <= 100)');
        DB::statement('ALTER TABLE `detalle_orden_compra` ADD CONSTRAINT `check_recibida` CHECK (`cantidad_recibida` >= 0)');
        DB::statement('ALTER TABLE `detalle_orden_compra` ADD CONSTRAINT `check_max_recibida` CHECK (`cantidad_recibida` <= `cantidad`)');
        DB::statement("ALTER TABLE `detalle_orden_compra` COMMENT 'Detalle de productos en órdenes de compra'");
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_orden_compra');
    }
};
