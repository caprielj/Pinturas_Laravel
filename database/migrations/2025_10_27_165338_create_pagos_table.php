<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')
                ->constrained('facturas')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('medio_pago_id')
                ->constrained('mediospago')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->decimal('monto', 12, 2);
            $table->string('referencia', 80)->nullable();
            $table->string('entidad', 80)->nullable();
            $table->string('transaccion_gateway_id', 80)->nullable();
            $table->string('autorizado_por', 120)->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Índices
            $table->index('factura_id', 'idx_pagos_factura');
            $table->index('medio_pago_id', 'idx_pagos_medio');
            $table->index('created_at', 'idx_pagos_fecha');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        // Constraint de validación
        DB::statement('ALTER TABLE `pagos` ADD CONSTRAINT `check_monto_positivo` CHECK (`monto` > 0)');

        DB::statement("ALTER TABLE `pagos` COMMENT 'Pagos recibidos por factura (permite múltiples pagos por factura)'");
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
