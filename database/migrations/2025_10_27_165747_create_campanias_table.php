<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campanias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 120);
            $table->text('cuerpo')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('usuarios')->onUpdate('cascade')->onDelete('set null');
            $table->dateTime('creado_en')->useCurrent();

            $table->index('creado_por', 'idx_campanias_creado_por');
            $table->index('creado_en', 'idx_campanias_fecha');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `campanias` COMMENT 'Campañas de marketing'");
    }

    public function down(): void
    {
        Schema::dropIfExists('campanias');
    }
};
