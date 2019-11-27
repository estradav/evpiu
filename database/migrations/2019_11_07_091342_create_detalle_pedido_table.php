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
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('idPedido');
            $table->string('CodigoProducto');
            $table->string('Descripcion');
            $table->string('Arte')->nullable();
            $table->string('Notas')->nullable();
            $table->string('Unidad');
            $table->string('Cantidad');
            $table->string('Precio');
            $table->string('Total');
            $table->string('Destino');
            $table->string('Estado')->nullable();
            $table->timestamps();
        });

        Schema::table('detalle_pedidos', function($table) {
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
        Schema::dropIfExists('detalle_pedido');
    }
}
