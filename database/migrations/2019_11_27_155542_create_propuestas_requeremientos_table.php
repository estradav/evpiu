<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropuestasRequeremientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuestas_requerimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idRequerimiento');
            $table->string('articulo');
            $table->string('relieve');
            $table->string('usuario');
            $table->string('estado');
            $table->timestamps();
        });
        Schema::table('propuestas_requerimientos', function($table) {
            $table->foreign('idRequerimiento')->references('id')->on('encabezado_requerimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propuestas_requeremientos');
    }
}
