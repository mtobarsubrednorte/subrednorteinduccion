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
        Schema::table('users', function (Blueprint $table) {
            $table->string('document_number')->nullable()->after('email');  // Número de documento
            $table->string('document_type')->nullable()->after('document_number'); // Tipo de documento
            $table->string('profile_id')->nullable()->after('document_type'); // Perfil del usuario
            $table->string('gender')->nullable()->after('profile_id'); // Sexo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['document_number', 'document_type', 'profile_id', 'gender']);
        });
    }
};