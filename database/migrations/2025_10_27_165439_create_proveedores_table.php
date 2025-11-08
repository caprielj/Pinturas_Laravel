<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('razon_social', 200)->nullable();
            $table->string('nit', 20)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('contacto_principal', 100)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index('nombre', 'idx_proveedores_nombre');
            $table->index('nit', 'idx_proveedores_nit');
            $table->index('activo', 'idx_proveedores_activo');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `proveedores` COMMENT 'Proveedores de productos'");
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
