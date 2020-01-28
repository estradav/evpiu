<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddForeignkeyToCodCodigos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cod_codigos', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario')->change();
            $table->unsignedBigInteger('usuario_aprobo')->change();
            $table->unsignedBigInteger('arte')->change();
        });

        Schema::table('cod_codigos', function (Blueprint $table) {
            $table->foreign('usuario')->references('id')->on('users');
            $table->foreign('usuario_aprobo')->references('id')->on('users');
            $table->foreign('arte')->references('id')->on('artes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cod_codigos', function (Blueprint $table) {
            //
        });
    }
}
