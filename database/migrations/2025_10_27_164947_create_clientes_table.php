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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('nit', 25)->unique()->nullable();
            $table->string('email', 150)->unique()->nullable();
            $table->string('password_hash', 255)->nullable();
            $table->boolean('opt_in_promos')->default(false);
            $table->boolean('verificado')->default(false);
            $table->string('telefono', 30)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->decimal('gps_lat', 10, 6)->nullable();
            $table->decimal('gps_lng', 10, 6)->nullable();
            $table->dateTime('creado_en')->useCurrent();

            // Índices
            $table->index('email', 'idx_clientes_email');
            $table->index('nit', 'idx_clientes_nit');
            $table->index(['gps_lat', 'gps_lng'], 'idx_clientes_gps');
            $table->index('verificado', 'idx_clientes_verificado');

            // Engine y charset
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `clientes` COMMENT 'Clientes del sistema'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
