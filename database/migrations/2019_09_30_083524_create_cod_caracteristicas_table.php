<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodCaracteristicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_caracteristicas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('cod');
            $table->string('name', 20);
            $table->string('abreviatura',10);
            $table->string('coments', 250);
            $table->string('usuario');
            $table->timestamps();


            $table->unsignedBigInteger('car_lineas_id');
            $table->foreign('car_lineas_id')->references('id')->on('cod_lineas');

            $table->unsignedBigInteger('car_sublineas_id');
            $table->foreign('car_sublineas_id')->references('id')->on('cod_sublineas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cod_caracteristicas');
    }
}
