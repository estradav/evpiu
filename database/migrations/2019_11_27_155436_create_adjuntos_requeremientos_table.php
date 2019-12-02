<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjuntosRequeremientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjuntos_requeremientos', function (Blueprint $table) {
            $table->unsignedBigInteger('idRequerimiento');
            $table->string('archivo');
            $table->string('usuario');
            $table->timestamps();
        });
        Schema::table('adjuntos_requeremientos', function($table) {
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
        Schema::dropIfExists('adjuntos_requeremientos');
    }
}
