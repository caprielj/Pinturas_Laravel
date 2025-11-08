<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presentaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 40)->unique();
            $table->string('unidad_base', 20)->nullable();
            $table->decimal('factor_galon', 10, 5)->nullable();
            $table->boolean('activo')->default(true);

            $table->index('activo', 'idx_presentaciones_activo');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `presentaciones` COMMENT 'Presentaciones disponibles (galón, litro, cuarto, etc.)'");
    }

    public function down(): void
    {
        Schema::dropIfExists('presentaciones');
    }
};
