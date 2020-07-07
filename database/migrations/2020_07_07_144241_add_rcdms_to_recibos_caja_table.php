<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRcdmsToRecibosCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recibos_caja', function (Blueprint $table) {
            $table->integer('rc_dms')->after('state')->nullable();
            $table->string('observaciones')->after('rc_dms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recibos_caja', function (Blueprint $table) {
            //
        });
    }
}
