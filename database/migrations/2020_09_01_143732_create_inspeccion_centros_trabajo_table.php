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
        Schema::create('inspeccion_centros_trabajo', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity_inspected');
            $table->integer('conforming_quantity');
            $table->integer('non_conforming_quantity');
            $table->string('cause');
            $table->unsignedBigInteger('operator_id');
            $table->foreign('operator_id')->references('id')->on('users');

            $table->unsignedBigInteger('inspector_id');
            $table->foreign('inspector_id')->references('id')->on('users');

            $table->longText('non-compliant treatment');
            $table->longText('action');
            $table->longText('observation');
            $table->string('centro');


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
