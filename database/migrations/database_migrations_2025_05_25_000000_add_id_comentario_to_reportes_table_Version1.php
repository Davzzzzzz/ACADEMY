<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reportes', function (Blueprint $table) {
            // Si ya hay datos, puedes permitir nulos al inicio
            $table->unsignedBigInteger('id_comentario')->nullable()->after('id_usuario');

            // Si quieres agregar la clave foránea y tu tabla comentarios se llama 'comentarios'
            $table->foreign('id_comentario')->references('id')->on('comentarios');
        });
    }

    public function down()
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->dropForeign(['id_comentario']);
            $table->dropColumn('id_comentario');
        });
    }
};
