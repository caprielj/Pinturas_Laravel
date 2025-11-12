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
        Schema::table('productos', function (Blueprint $table) {
            // Agregar campo para almacenar la ruta de la imagen del producto
            // nullable(): permite que sea null si no se sube imagen
            // after('color'): coloca el campo después de la columna 'color'
            $table->string('imagen', 255)->nullable()->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Eliminar el campo imagen si hacemos rollback
            $table->dropColumn('imagen');
        });
    }
};
