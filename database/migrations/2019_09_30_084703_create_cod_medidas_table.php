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
            $table->bigIncrements('id');
            $table->string('cod');
            $table->string('denominacion', 30);
            $table->string('diametro')->nullable();
            $table->string('largo')->nullable();
            $table->string('espesor')->nullable();
            $table->string('base')->nullable();
            $table->string('altura')->nullable();
            $table->string('perforacion')->nullable();
            $table->string('mm2')->nullable();
            $table->string('undmedida')->nullable();
            $table->string('coments', 250)->nullable();
            $table->string('usuario')->nullable();
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
