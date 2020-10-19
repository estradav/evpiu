<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendedorIdToEncabezadoPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('encabezado_pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('vendedor_id')->nullable()->after('CodCliente');
            $table->foreign('vendedor_id')->references('id')->on('users');
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
