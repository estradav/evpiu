<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignkeyToCodLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cod_lineas', function (Blueprint $table) {
            $table->dropForeign(['tipoproducto_id']);
            $table->dropColumn('tipoproducto_id');
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
