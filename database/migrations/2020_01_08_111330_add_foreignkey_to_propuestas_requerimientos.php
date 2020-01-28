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
            $table->foreign('idRequerimiento')->references('id')->on('encabezado_requerimientos');
            $table->foreign('articulo')->references('id')->on('cod_codigos');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('diseñador_id')->references('id')->on('users');
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
