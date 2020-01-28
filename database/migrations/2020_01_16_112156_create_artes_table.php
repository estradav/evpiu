<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->unsignedBigInteger('marca_id')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->string('caracteristicas');
            $table->string('2d');
            $table->string('3d');
            $table->string('plano');
            $table->unsignedBigInteger('diseñador_id')->nullable();
            $table->unsignedBigInteger('vendedor_id')->nullable();
            $table->unsignedBigInteger('propuesta_id')->nullable();
            $table->string('comentarios')->nullable();
            $table->string('estado')->default('1');
            $table->timestamps();
        });


        Schema::table('artes', function (Blueprint $table) {
            $table->foreign('diseñador_id')->references('id')->on('users');
            $table->foreign('vendedor_id')->references('id')->on('users');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('producto_id')->references('id')->on('cod_codigos');
            $table->foreign('propuesta_id')->references('id')->on('propuestas_requerimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artes');
    }
}
