<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('foros', function (Blueprint $table) {
            $table->id(); // Usa el nombre estándar 'id'
            $table->string('titulo', 255);
            $table->text('descripcion');
            $table->date('fecha_creacion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foros');
    }
};
