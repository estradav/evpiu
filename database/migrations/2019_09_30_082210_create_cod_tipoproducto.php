<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodTipoproducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_tipoproducto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod');
            $table->string('name', 20);
            $table->string('coments',250);
            $table->string('usuario');
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
        Schema::dropIfExists('cod_tipoproducto');
    }
}
