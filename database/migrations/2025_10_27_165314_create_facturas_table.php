<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('serie', 10);
            $table->dateTime('fecha_emision')->useCurrent();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('sucursal_id')
                ->constrained('sucursales')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('estado', ['EMITIDA', 'ANULADA'])->default('EMITIDA');
            $table->foreignId('anulada_por')
                ->nullable()
                ->constrained('usuarios')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->dateTime('anulada_fecha')->nullable();
            $table->string('motivo_anulacion', 255)->nullable();

            // Índices
            $table->unique(['numero', 'serie'], 'unique_factura');
            $table->index('fecha_emision', 'idx_facturas_fecha');
            $table->index(['cliente_id', 'fecha_emision'], 'idx_facturas_cliente');
            $table->index('estado', 'idx_facturas_estado');
            $table->index('sucursal_id', 'idx_facturas_sucursal');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `facturas` COMMENT 'Facturas de venta'");
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
