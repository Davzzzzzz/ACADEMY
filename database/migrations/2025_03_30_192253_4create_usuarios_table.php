<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id(); // Crea 'id' como PK
            $table->string('nombre', 100);
            $table->string('correo', 100)->unique();
            $table->string('contrasena', 255);
            $table->date('fecha_registro');
            $table->foreignId('id_rol')->constrained('roles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario');
    }
};
