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
        Schema::create('racha', function (Blueprint $table) {
            $table->id('id_racha');
            $table->unsignedBigInteger('id_usuario');
            $table->integer('dias_consecutivos');
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('racha');
    }
};
