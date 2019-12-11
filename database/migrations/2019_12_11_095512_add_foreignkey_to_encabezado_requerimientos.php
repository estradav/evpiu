<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkeyToEncabezadoRequerimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('encabezado_requerimientos', function (Blueprint $table) {
            $table->foreign('vendedor_id')->references('codvendedor')->on('users');
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
        Schema::table('encabezado_requerimientos', function (Blueprint $table) {
            //
        });
    }
}
