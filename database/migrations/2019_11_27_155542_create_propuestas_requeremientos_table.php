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
        Schema::create('propuestas_requeremientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idRequerimiento');
            $table->string('articulo');
            $table->string('material');
            $table->string('tamaño');
            $table->string('relieve');
            $table->string('marca');
            $table->string('diseñador');
            $table->string('vendedor');
            $table->string('estado');
            $table->timestamps();
        });
        Schema::table('propuestas_requeremientos', function($table) {
            $table->foreign('idRequerimiento')->references('id')->on('maestro_requeremientos');
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
