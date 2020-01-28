<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaccionesRequeremientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones_requerimientos', function (Blueprint $table) {
            $table->unsignedBigInteger('idReq');
            $table->string('tipo');
            $table->string('descripcion');
            $table->unsignedBigInteger('usuario_id')->index()->nullable();
            $table->timestamps();
        });

        Schema::table('transacciones_requerimientos', function($table) {
            $table->foreign('idReq')->references('id')->on('encabezado_requerimientos');
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacciones_requerimientos');
    }
}
