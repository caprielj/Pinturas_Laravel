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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('dpi', 20)->unique();
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255);
            $table->foreignId('rol_id')
                ->constrained('roles')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('sucursal_id')
                ->nullable()
                ->constrained('sucursales')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->boolean('activo')->default(true);
            $table->dateTime('creado_en')->useCurrent();

            // Índices adicionales
            $table->index('rol_id', 'idx_usuarios_rol');
            $table->index('sucursal_id', 'idx_usuarios_sucursal');
            $table->index('email', 'idx_usuarios_email');
            $table->index('dpi', 'idx_usuarios_dpi');
            $table->index('activo', 'idx_usuarios_activo');

            // Engine y charset
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        // Agregar comentario a la tabla
        DB::statement("ALTER TABLE `usuarios` COMMENT 'Usuarios del sistema'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
