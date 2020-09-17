<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkeyToCodLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cod_lineas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tipo_producto')->nullable()->after('coments');
            $table->foreign('id_tipo_producto')->references('id')->on('cod_tipo_productos');
            $table->dropColumn(['usuario']);

            $table->unsignedBigInteger('user_id')->nullable()->after('id_tipo_producto');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cod_lineas', function (Blueprint $table) {
            //
        });
    }
}
