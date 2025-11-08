<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mediospago', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60)->unique();
            $table->boolean('activo')->default(true);

            $table->index('activo', 'idx_mediospago_activo');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        DB::statement("ALTER TABLE `mediospago` COMMENT 'Medios de pago disponibles'");
    }

    public function down(): void
    {
        Schema::dropIfExists('mediospago');
    }
};
