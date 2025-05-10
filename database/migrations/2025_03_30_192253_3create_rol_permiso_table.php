<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('rol_permiso', function (Blueprint $table) {
            // No uses $table->id() aquí
            $table->unsignedBigInteger('id_rol'); // Debe ser mismo tipo que id en roles
            $table->unsignedBigInteger('id_permiso'); // Debe ser mismo tipo que id en permisos
            $table->timestamps();

            // Define la clave primaria compuesta
            $table->primary(['id_rol', 'id_permiso']);

            // Define las claves foráneas
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('id_permiso')->references('id')->on('permisos')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('rol_permiso');
    }
};
