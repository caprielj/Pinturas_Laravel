<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detallecotizacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('producto_presentacion_id')->constrained('productopresentacion')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('descuento_pct_aplicado', 5, 2)->default(0);
            $table->decimal('subtotal', 12, 2);

            $table->index('cotizacion_id', 'idx_detallecotizacion_cotizacion');
            $table->unique(['cotizacion_id', 'producto_presentacion_id'], 'unique_cotizacion_producto');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement('ALTER TABLE `detallecotizacion` ADD CONSTRAINT `check_cant_cot` CHECK (`cantidad` > 0)');
        DB::statement('ALTER TABLE `detallecotizacion` ADD CONSTRAINT `check_precio_cot` CHECK (`precio_unitario` >= 0)');
        DB::statement("ALTER TABLE `detallecotizacion` COMMENT 'Detalle de productos en cotizaciones'");
    }

    public function down(): void
    {
        Schema::dropIfExists('detallecotizacion');
    }
};
