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
    Schema::table('racha', function (Blueprint $table) {
        $table->date('ultima_fecha')->nullable();
    });
}

public function down()
{
    Schema::table('racha', function (Blueprint $table) {
        $table->dropColumn('ultima_fecha');
    });
}

};
