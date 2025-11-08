<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs_sistema', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_hora')->useCurrent();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->onUpdate('cascade')->onDelete('set null');
            $table->string('tabla_afectada', 100)->nullable();
            $table->string('accion', 50)->nullable();
            $table->string('registro_afectado_id', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->text('valores_antes')->nullable();
            $table->text('valores_despues')->nullable();
            $table->string('ip_origen', 64)->nullable();
            $table->string('dispositivo', 100)->nullable();
            $table->string('estado', 20)->nullable();

            $table->index('fecha_hora', 'idx_logs_fecha');
            $table->index(['usuario_id', 'fecha_hora'], 'idx_logs_usuario');
            $table->index(['tabla_afectada', 'accion'], 'idx_logs_tabla');
            $table->index('accion', 'idx_logs_accion');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `logs_sistema` COMMENT 'Registro de auditoría del sistema'");
    }

    public function down(): void
    {
        Schema::dropIfExists('logs_sistema');
    }
};
