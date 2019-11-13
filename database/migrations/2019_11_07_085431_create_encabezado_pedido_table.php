<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncabezadoPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encabezado_pedido', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('OrdenCompra');
            $table->string('CodCliente');
            $table->string('NombreCliente');
            $table->string('DireccionCliente');
            $table->string('Ciudad');
            $table->string('Telefono');
            $table->string('CodVendedor');
            $table->string('NombreVendedor');
            $table->string('CondicionPago');
            $table->string('Descuento');
            $table->string('Iva');
            $table->string('Estado');
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
        Schema::dropIfExists('encabezado_pedido');
    }
}
