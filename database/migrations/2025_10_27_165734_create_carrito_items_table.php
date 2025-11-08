<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')->constrained('carritos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('producto_presentacion_id')->constrained('productopresentacion')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2)->nullable();
            $table->decimal('descuento_pct', 5, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->nullable();

            $table->index('carrito_id', 'idx_carrito_items_carrito');
            $table->unique(['carrito_id', 'producto_presentacion_id'], 'unique_carrito_producto');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement('ALTER TABLE `carrito_items` ADD CONSTRAINT `check_cantidad_carrito` CHECK (`cantidad` > 0)');
        DB::statement("ALTER TABLE `carrito_items` COMMENT 'Items en los carritos de compra'");
    }

    public function down(): void
    {
        Schema::dropIfExists('carrito_items');
    }
};
