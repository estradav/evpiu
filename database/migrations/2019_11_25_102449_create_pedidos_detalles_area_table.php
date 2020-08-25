<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosDetallesAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_detalles_area', function (Blueprint $table) {
            $table->unsignedBigInteger('idPedido');
            $table->string('Cartera',3)->nullable();
            $table->string('DetalleCartera',250)->nullable();
            $table->string('AproboCartera')->nullable();
            $table->string('Costos',3)->nullable();
            $table->string('DetalleCostos',250)->nullable();
            $table->string('AproboCostos')->nullable();
            $table->string('Produccion',3)->nullable();
            $table->string('DetalleProduccion',250)->nullable();
            $table->string('AproboProduccion')->nullable();
            $table->string('Bodega',3)->nullable();
            $table->string('DetalleBodega',250)->nullable();
            $table->string('AproboBodega')->nullable();
            $table->timestamps();
        });

        Schema::table('pedidos_detalles_area', function($table) {
            $table->foreign('idPedido')->references('id')->on('encabezado_pedidos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos_detalles_area');
    }
}
