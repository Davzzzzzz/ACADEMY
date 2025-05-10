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
        Schema::create('niveles', function (Blueprint $table) {
            $table->id('id_nivel');
            $table->enum('nombre_nivel', ['Principiante', 'Intermedio', 'Avanzado']);
            $table->text('descripcion');
        });
    }
    public function down()
    {
        Schema::dropIfExists('niveles');
    }
};
