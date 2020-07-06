<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametrosRetencionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros_retenciones', function (Blueprint $table) {
            $table->id();
            $table->integer('año')->unique();
            $table->string('tipo_retencion');
            $table->float('base');
            $table->integer('porcentaje');
            $table->string('comentarios')->nullable();;
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
        Schema::dropIfExists('parametros_retenciones');
    }
}
