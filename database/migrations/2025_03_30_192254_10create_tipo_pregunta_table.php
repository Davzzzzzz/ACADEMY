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
        Schema::create('tipo_pregunta', function (Blueprint $table) {
            $table->id('id_tipo_pregunta');
            $table->enum('tipo', ['opcion_multiple', 'verdadero_falso', 'respuesta_abierta']);
        });
    }
    public function down()
    {
        Schema::dropIfExists('tipo_pregunta');
    }
};
