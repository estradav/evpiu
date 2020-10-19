<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFieldsToPedidosDetallesAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos_detalles_area', function (Blueprint $table) {
            $table->dropColumn('AproboCartera', 'AproboCostos', 'AproboProduccion', 'AproboBodega');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos_detalles_area', function (Blueprint $table) {
            //
        });
    }
}
