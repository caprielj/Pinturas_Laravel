<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')
                ->nullable()
                ->constrained('categorias')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('marca_id')
                ->nullable()
                ->constrained('marcas')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('codigo_sku', 50)->unique();
            $table->string('descripcion', 255);
            $table->string('tamano', 40)->nullable();
            $table->integer('duracion_anios')->nullable();
            $table->decimal('extension_m2', 10, 2)->nullable();
            $table->string('color', 60)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Índices
            $table->index('categoria_id', 'idx_productos_categoria');
            $table->index('marca_id', 'idx_productos_marca');
            $table->index('activo', 'idx_productos_activo');
            $table->index('codigo_sku', 'idx_productos_sku');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `productos` COMMENT 'Productos del catálogo'");
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
