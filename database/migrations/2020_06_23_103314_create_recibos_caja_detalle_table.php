<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibosCajaDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos_caja_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_recibo');
            $table->integer('invoice');
            $table->string('bruto');
            $table->string('descuento');
            $table->string('retenecion');
            $table->string('reteiva');
            $table->string('reteica');
            $table->string('otras_deduc');
            $table->string('otros_ingre');
            $table->string('total');
            $table->timestamps();



            $table->foreign('id_recibo')->references('id')->on('recibos_caja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recibos_caja_detalle');
    }
}
