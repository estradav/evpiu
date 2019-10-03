<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodMedidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_medidas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('cod');
            $table->string('name', 20);
            $table->string('denominacion',10);
            $table->string('exterior');
            $table->string('interior');
            $table->string('largo');
            $table->string('lado_1');
            $table->string('lado_2');
            $table->string('coments', 250);
            $table->string('usuario');
            $table->timestamps();


            $table->unsignedBigInteger('med_lineas_id');
            $table->foreign('med_lineas_id')->references('id')->on('cod_lineas');

            $table->unsignedBigInteger('med_sublineas_id');
            $table->foreign('med_sublineas_id')->references('id')->on('cod_sublineas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cod_medidas');
    }
}
