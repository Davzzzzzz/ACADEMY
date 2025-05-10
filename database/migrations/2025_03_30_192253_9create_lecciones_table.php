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
        Schema::create('lecciones', function (Blueprint $table) {
            $table->id('id_leccion');
            $table->unsignedBigInteger('id_nivel');
            $table->string('titulo', 255);
            $table->text('contenido');
            $table->foreign('id_nivel')->references('id_nivel')->on('niveles')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('lecciones');
    }
};
