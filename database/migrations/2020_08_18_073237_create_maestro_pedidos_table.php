<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaestroPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maestro_pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bodega')->nullable();
            $table->foreign('id_bodega')->references('id')->on('encabezado_pedidos');
            $table->unsignedBigInteger('id_produccion')->nullable();
            $table->foreign('id_produccion')->references('id')->on('encabezado_pedidos');
            $table->unsignedBigInteger('id_troqueles')->nullable();
            $table->foreign('id_troqueles')->references('id')->on('encabezado_pedidos');
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
        Schema::dropIfExists('maestro_pedidos');
    }
}
