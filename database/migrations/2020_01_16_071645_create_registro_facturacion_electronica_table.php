<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroFacturacionElectronicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_facturacion_electronica', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero_factura', 100);
            $table->string('id_factible', 100);
            $table->string('usuario', 100);
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
        Schema::dropIfExists('registro_facturacion_electronica');
    }
}
