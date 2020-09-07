<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionCentrosTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_work_centers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('production_order')->comment('Numero de orden de produccion');
            $table->bigInteger('quantity_inspected')->comment('Cantidad inspeccionada');
            $table->bigInteger('conforming_quantity')->comment('Cantidad conforme');
            $table->bigInteger('non_conforming_quantity')->comment('Cantidad no conforme');
            $table->string('cause')->comment('causa de la no conformidad');

            $table->unsignedBigInteger('operator_id')->comment('Operario');
            $table->foreign('operator_id')->references('id')->on('users');

            $table->unsignedBigInteger('inspector_id')->comment('Inspector que realiza la revision');;
            $table->foreign('inspector_id')->references('id')->on('users');

            $table->longText('non-compliant_treatment')->comment('tratamiento a la no conformidad');
            $table->longText('action')->comment('accion realizada');
            $table->longText('observation')->comment('observaciones');
            $table->string('center')->comment('centro de trabajo');
            
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
        Schema::dropIfExists('inspeccion_centros_trabajo');
    }
}
