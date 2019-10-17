<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodCodigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_codigos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('codigo', 100);
            $table->string('coments');
            $table->string('descripcion')->nullable();
            $table->string('usuario')->nullable();
            $table->string('usuario_aprobo', 100)->nullable();
            $table->string('arte')->nullable();
            $table->string('estado')->nullable();
            $table->string('area')->nullable();
            $table->string('costo_base')->nullable();
            $table->string('generico')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('cod_tipo_producto_id');
            $table->foreign('cod_tipo_producto_id')->references('id')->on('cod_tipo_productos');

            $table->unsignedBigInteger('cod_lineas_id');
            $table->foreign('cod_lineas_id')->references('id')->on('cod_lineas');


            $table->unsignedBigInteger('cod_sublineas_id');
            $table->foreign('cod_sublineas_id')->references('id')->on('cod_sublineas');


            $table->unsignedBigInteger('cod_medidas_id');
            $table->foreign('cod_medidas_id')->references('id')->on('cod_medidas');


            $table->unsignedBigInteger('cod_caracteristicas_id');
            $table->foreign('cod_caracteristicas_id')->references('id')->on('cod_caracteristicas');


            $table->unsignedBigInteger('cod_materials_id');
            $table->foreign('cod_materials_id')->references('id')->on('cod_materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cod_codigos');
    }
}
