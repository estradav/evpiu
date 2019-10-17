<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodSublineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_sublineas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('cod');
            $table->string('name',20);
            $table->string('abreviatura',10);
            $table->string('coments', 250);
            $table->string('usuario');
            $table->timestamps();

            $table->unsignedBigInteger('lineas_id');
            $table->foreign('lineas_id')->references('id')->on('cod_lineas');

            $table->unsignedBigInteger('tipoproductos_id');
            $table->foreign('tipoproductos_id')->references('id')->on('cod_tipo_productos');
        });
    }

    /**cd hoº
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cod_sublineas');
    }
}
