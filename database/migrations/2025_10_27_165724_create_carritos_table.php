<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursales')->onUpdate('cascade')->onDelete('set null');
            $table->string('estado', 20)->default('ABIERTO');
            $table->dateTime('creado_en')->useCurrent();
            $table->dateTime('actualizado_en')->nullable();

            $table->index(['cliente_id', 'estado'], 'idx_carritos_cliente');
            $table->index('estado', 'idx_carritos_estado');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `carritos` COMMENT 'Carritos de compra de clientes'");
    }

    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
