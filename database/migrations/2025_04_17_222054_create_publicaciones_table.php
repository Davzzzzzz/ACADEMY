<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();

            // Relación con 'usuario.id'
            $table->foreignId('id_usuario')->constrained('usuario')->onDelete('cascade');

            // Relación con 'foros.id'
            $table->foreignId('foro_id')->constrained('foros')->onDelete('cascade');

            // Para respuestas anidadas
            $table->foreignId('parent_id')->nullable()->constrained('publicaciones')->onDelete('cascade');

            $table->text('contenido');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publicaciones');
    }
};
