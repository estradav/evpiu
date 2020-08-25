<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToFeConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fe_configs', function (Blueprint $table) {
            /*Facturacion exportaciones*/
            $table->integer('fac_exp_id_numeracion')->after('fac_idreporte');
            $table->integer('fac_exp_id_ambiente')->after('fac_exp_id_numeracion');
            $table->integer('fac_exp_id_reporte')->after('fac_exp_id_ambiente');

            $table->integer('nc_exp_id_numeracion')->after('nc_idreporte');
            $table->integer('nc_exp_id_ambiente')->after('nc_exp_id_numeracion');
            $table->integer('nc_exp_id_reporte')->after('nc_exp_id_ambiente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fe_configs', function (Blueprint $table) {
            //
        });
    }
}
