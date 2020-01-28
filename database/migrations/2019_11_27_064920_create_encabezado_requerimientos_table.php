<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncabezadoRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encabezado_requerimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('producto')->nullable();
            $table->string('informacion');
            $table->string('cliente');
            $table->unsignedBigInteger('marca')->nullable();
            $table->string('medida');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->string('estado');
            $table->string('render');
            $table->unsignedBigInteger('vendedor_id')->nullable();
            $table->unsignedBigInteger('diseñador_id')->nullable();

            $table->timestamps();
        });

/*        $table->foreign('vendedor_id')->references('codvendedor')->on('users');
        $table->foreign('diseñador_id')->references('cod_designer')->on('users');*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encabezado_requerimientos');
    }
}
