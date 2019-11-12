<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallePedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pedido', function (Blueprint $table) {
            $table->unsignedBigInteger('idPedido');
            $table->string('CodigoProducto');
            $table->string('Descripcion');
            $table->string('Notas');
            $table->string('Unidad');
            $table->string('Cantidad');
            $table->string('Precio');
            $table->string('Total');
            $table->string('Estado');
            $table->timestamps();

            $table->foreign('idPedido')->references('id')->on('encabezado_pedido');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_pedido');
    }
}
