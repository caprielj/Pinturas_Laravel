<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campania_adjuntos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campania_id')->constrained('campanias')->onUpdate('cascade')->onDelete('cascade');
            $table->string('tipo', 20);
            $table->string('url', 255);
            $table->string('descripcion', 255)->nullable();

            $table->index('campania_id', 'idx_campania_adjuntos_campania');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `campania_adjuntos` COMMENT 'Archivos adjuntos a campañas'");
    }

    public function down(): void
    {
        Schema::dropIfExists('campania_adjuntos');
    }
};
