<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fe_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fac_idnumeracion');
            $table->string('fac_idambiente');
            $table->string('fac_idreporte');

            $table->string('nc_idnumeracion');
            $table->string('nc_idambiente');
            $table->string('nc_idreporte');
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
        Schema::dropIfExists('fe_configs');
    }
}
