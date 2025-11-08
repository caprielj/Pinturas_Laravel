<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campania_destinatarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campania_id')->constrained('campanias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('estado', 20)->default('PENDIENTE');
            $table->string('detalle', 255)->nullable();
            $table->dateTime('enviado_en')->nullable();

            $table->index('campania_id', 'idx_campania_dest_campania');
            $table->unique(['campania_id', 'cliente_id'], 'unique_campania_cliente');
            $table->index('estado', 'idx_campania_dest_estado');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `campania_destinatarios` COMMENT 'Destinatarios de campañas'");
    }

    public function down(): void
    {
        Schema::dropIfExists('campania_destinatarios');
    }
};
