<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Primero eliminamos la llave foránea existente
            $table->dropForeign(['user_id']);
        });

        Schema::table('certificates', function (Blueprint $table) {
            // Creamos la llave foránea nuevamente SIN CASCADA
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict'); // opciones: restrict, set null o nada
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Revertimos: eliminamos la llave modificada
            $table->dropForeign(['user_id']);
        });

        Schema::table('certificates', function (Blueprint $table) {
            // Volvemos a poner la original con cascade
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
