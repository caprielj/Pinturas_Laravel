<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('secuencias_facturas', function (Blueprint $table) {
            $table->id();
            $table->string('serie', 10)->unique();
            $table->integer('ultimo_numero')->default(0);
            $table->string('descripcion', 150)->nullable();
            $table->boolean('activa')->default(true);

            $table->index('serie', 'idx_secuencias_serie');
            $table->index('activa', 'idx_secuencias_activa');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `secuencias_facturas` COMMENT 'Control de secuencias para numeración de documentos'");
    }

    public function down(): void
    {
        Schema::dropIfExists('secuencias_facturas');
    }
};
