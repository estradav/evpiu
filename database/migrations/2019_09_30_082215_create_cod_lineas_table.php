<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_lineas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('cod');
            $table->string('name', 20);
            $table->string('abreviatura',10);
            $table->string('coments',250);
            $table->string('usuario')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('tipoproducto_id');
            $table->foreign('tipoproducto_id')->references('id')->on('cod_tipo_productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cod_lineas');
    }
}
