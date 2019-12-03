<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaestroRequeremientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maestro_requerimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('producto');
            $table->string('informacion');
            $table->string('marca');
            $table->unsignedBigInteger('vendedor_id');
            $table->string('usuario');
            $table->unsignedBigInteger('diseñador_id');
            $table->string('estado');
            $table->string('render');

            $table->timestamps();
        });

        Schema::table('maestro_requerimientos', function($table) {
            $table->foreign('vendedor_id')->references('cod_vendedor')->on('users');
            $table->foreign('diseñador_id')->references('diseñador')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maestro_requeremientos');
    }
}
