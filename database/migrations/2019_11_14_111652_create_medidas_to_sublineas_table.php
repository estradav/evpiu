<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedidasToSublineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medidas_to_sublineas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('med_id')->unsigned();
            $table->foreign('med_id')->references('id')->on('unidades_medidas');

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
        Schema::dropIfExists('medidas_to_sublineas');
    }
}
