<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla Cotizaciones
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('serie', 10);
            $table->dateTime('fecha')->useCurrent();
            $table->foreignId('cliente_id')
                ->nullable()
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
            $table->dateTime('vigente_hasta')->nullable();
            $table->string('estado', 20)->default('ABIERTA');

            // Índices
            $table->unique(['numero', 'serie'], 'unique_cotizacion');
            $table->index(['cliente_id', 'fecha'], 'idx_cotizaciones_cliente');
            $table->index('estado', 'idx_cotizaciones_estado');
            $table->index('fecha', 'idx_cotizaciones_fecha');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `cotizaciones` COMMENT 'Cotizaciones para clientes'");
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
