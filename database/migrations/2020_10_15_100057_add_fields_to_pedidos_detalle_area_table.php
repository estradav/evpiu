<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPedidosDetalleAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos_detalles_area', function (Blueprint $table) {
            $table->dateTime('cartera_fecha_resp')->nullable()->after('DetalleCartera');
            $table->unsignedBigInteger('aprobo_cartera')->nullable()->after('cartera_fecha_resp');
            $table->foreign('aprobo_cartera')->references('id')->on('users');


            $table->dateTime('costos_fecha_resp')->nullable()->after('DetalleCostos');
            $table->unsignedBigInteger('aprobo_costos')->nullable()->after('costos_fecha_resp');
            $table->foreign('aprobo_costos')->references('id')->on('users');


            $table->dateTime('produccion_fecha_resp')->nullable()->after('DetalleProduccion');
            $table->unsignedBigInteger('aprobo_produccion')->nullable()->after('produccion_fecha_resp');
            $table->foreign('aprobo_produccion')->references('id')->on('users');


            $table->dateTime('bodega_fecha_respuesta')->nullable()->after('DetalleBodega');
            $table->unsignedBigInteger('aprobo_bodega')->nullable()->after('bodega_fecha_respuesta');
            $table->foreign('aprobo_bodega')->references('id')->on('users');


            $table->string('Troqueles')->nullable()->after('AproboBodega');
            $table->string('DetalleTroqueles')->nullable()->after('Troqueles');
            $table->dateTime('troqueles_fecha_respuesta')->nullable()->after('DetalleTroqueles');
            $table->unsignedBigInteger('aprobo_troqueles')->nullable()->after('troqueles_fecha_respuesta');
            $table->foreign('aprobo_troqueles')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos_detalle_area', function (Blueprint $table) {
            //
        });
    }
}
