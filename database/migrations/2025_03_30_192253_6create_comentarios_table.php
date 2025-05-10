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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id(); // Crea 'id' como clave primaria estándar

            // Relación con la tabla 'usuario'
            $table->foreignId('id_usuario')->constrained('usuario')->onDelete('cascade');

            // Relación con la tabla 'foros' (ahora usando 'id', no 'id_foro')
            $table->foreignId('foro_id')->constrained('foros')->onDelete('cascade');

            $table->text('contenido');
            $table->date('fecha_publicacion');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
};

