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
        Schema::create('recursos', function (Blueprint $table) {
            $table->id('id_recurso');
            $table->unsignedBigInteger('id_leccion');
            $table->enum('tipo', ['video', 'imagen', 'documento']);
            $table->string('url', 255);
            $table->foreign('id_leccion')->references('id_leccion')->on('lecciones')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('recursos');
    }
};
