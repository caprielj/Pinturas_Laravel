<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80)->unique();
            $table->boolean('activa')->default(true);

            $table->index('activa', 'idx_marcas_activa');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `marcas` COMMENT 'Marcas de productos'");
    }

    public function down(): void
    {
        Schema::dropIfExists('marcas');
    }
};
