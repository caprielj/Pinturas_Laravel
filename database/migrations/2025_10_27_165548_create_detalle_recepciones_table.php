<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_recepciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recepcion_id')->constrained('recepciones')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('detalle_orden_id')->constrained('detalle_orden_compra')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('cantidad_recibida');
            $table->string('observaciones', 255)->nullable();

            $table->index('recepcion_id', 'idx_detalle_recep_recepcion');
            $table->index('detalle_orden_id', 'idx_detalle_recep_orden');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement('ALTER TABLE `detalle_recepciones` ADD CONSTRAINT `check_cantidad_rec` CHECK (`cantidad_recibida` > 0)');
        DB::statement("ALTER TABLE `detalle_recepciones` COMMENT 'Detalle de productos recibidos en cada recepción'");
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_recepciones');
    }
};
