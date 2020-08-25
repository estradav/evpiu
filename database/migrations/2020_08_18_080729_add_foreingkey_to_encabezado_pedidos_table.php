<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeingkeyToEncabezadoPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('encabezado_pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_maestro')->nullable();
            $table->foreign('id_maestro')->references('id')->on('maestro_pedidos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('encabezado_pedidos', function (Blueprint $table) {
            //
        });
    }
}
