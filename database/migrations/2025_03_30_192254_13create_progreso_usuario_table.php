<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('progreso_usuario', function (Blueprint $table) {
            $table->id('id_progreso');
            $table->foreignId('id_usuario')->constrained('usuario', 'id')->onDelete('cascade');
            $table->foreignId('id_nivel')->constrained('niveles', 'id_nivel')->onDelete('cascade');
            $table->foreignId('id_leccion_actual')->constrained('lecciones', 'id_leccion')->onDelete('cascade');
            $table->integer('ejercicios_completados');
        });
    }

    public function down()
    {
        Schema::dropIfExists('progreso_usuario');
    }
};
