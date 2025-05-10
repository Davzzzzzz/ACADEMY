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
        Schema::create('ejercicios', function (Blueprint $table) {
            $table->id('id_ejercicio');
            $table->unsignedBigInteger('id_leccion');
            $table->unsignedBigInteger('id_tipo_pregunta');
            $table->text('pregunta');
            $table->string('imagen_pregunta', 255)->nullable(); // Nuevo campo agregado
            $table->text('opciones');
            $table->text('respuesta_correcta');

            $table->foreign('id_leccion')->references('id_leccion')->on('lecciones')->onDelete('cascade');
            $table->foreign('id_tipo_pregunta')->references('id_tipo_pregunta')->on('tipo_pregunta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ejercicios');
    }
};
