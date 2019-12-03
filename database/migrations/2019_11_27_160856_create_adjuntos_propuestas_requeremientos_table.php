<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjuntosPropuestasRequeremientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjuntos_propuestas_requerimientos', function (Blueprint $table) {
            $table->unsignedBigInteger('idRequerimiento');
            $table->string('archivo');
            $table->string('usuario');
            $table->timestamps();
        });

        Schema::table('adjuntos_propuestas_requerimientos', function($table) {
            $table->foreign('idRequerimiento')->references('id')->on('maestro_requerimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjuntos_propuestas_requerimientos');
    }
}
