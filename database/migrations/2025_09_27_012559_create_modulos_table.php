<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('duration'); // duration in minutes
            $table->text('genilay_recursos_link1')->nullable();
            $table->text('genilay_recursos_link2')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable(); // submódulo opcional
            $table->foreign('parent_id')->references('id')->on('modulos')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos');
    }
};
