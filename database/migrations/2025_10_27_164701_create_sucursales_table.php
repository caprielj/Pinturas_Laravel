<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120)->unique();
            $table->string('direccion', 255)->nullable();
            $table->decimal('gps_lat', 10, 6)->nullable();
            $table->decimal('gps_lng', 10, 6)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->boolean('activa')->default(true);

            // Índices
            $table->index(['gps_lat', 'gps_lng'], 'idx_sucursales_gps');
            $table->index('activa', 'idx_sucursales_activa');

            // Engine y charset
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        // Agregar comentario a la tabla
        DB::statement("ALTER TABLE `sucursales` COMMENT 'Sucursales de la empresa'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};
