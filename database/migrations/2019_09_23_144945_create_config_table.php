<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fe_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_numeracion_fac');
            $table->string('id_numeracion_nc');
            $table->string('id_numeracion_nd');
            $table->enum('id_ambiente', ['1', '2']);
            $table->string('id_reporte_fac');
            $table->string('id_reporte_nc');
            $table->string('id_reporte_nd');
            $table->enum('id_estado_envio_Cliente',['3', '4']);
            $table->enum('id_estado_envio_dian',['3', '4']);
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
        Schema::dropIfExists('fe_configs');
    }
}
