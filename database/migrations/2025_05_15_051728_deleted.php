<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('foros', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('comentarios', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reportes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('progreso_usuario', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('racha', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('foros', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('reportes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('progreso_usuario', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('racha', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
