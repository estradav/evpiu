<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkeyToPropuestasRequerimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('propuestas_requerimientos', function (Blueprint $table) {
            $table->foreign('diseñador_id')->references('cod_designer')->on('users');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('propuestas_requerimientos', function (Blueprint $table) {
            //
        });
    }
}
