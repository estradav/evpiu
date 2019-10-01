<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodSublineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_sublineas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cod');
            $table->string('name',20);
            $table->string('abreviatura',10);
            $table->string('coments', 250);
            $table->string('usuario');
            $table->timestamps();
        });
    }

    /**cd ho
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cod_sublineas');
    }
}
