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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id('id_reporte');
            $table->foreignId('id_usuario')->constrained('usuario', 'id')->onDelete('cascade');
            $table->text('descripcion');
            $table->date('fecha_reporte');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reportes');
    }
};
