<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaracteristicasmedidasToSublineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracteristicasmedidas_to_sublineas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('car_med_id')->unsigned();
            $table->foreign('car_med_id')->references('id')->on('caracteristicas_unidades_medidas');

            $table->unsignedBigInteger('sub_id')->unsigned();
            $table->foreign('sub_id')->references('id')->on('cod_sublineas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caracteristicasmedidas_to_sublineas');
    }
}
