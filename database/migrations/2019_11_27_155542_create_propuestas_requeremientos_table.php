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
            $table->unsignedBigInteger('articulo')->nullable();
            $table->string('codigo_base');
            $table->string('relieve');
            $table->string('medida');
            $table->string('caracteristicas');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->string('estado');
            $table->unsignedBigInteger('diseñador_id')->nullable();
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
        Schema::dropIfExists('propuestas_requeremientos');
    }
}
