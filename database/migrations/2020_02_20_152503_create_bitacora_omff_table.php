<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacoraOmffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_omff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('machine');
            $table->string('tb');
            $table->string('rz');
            $table->string('vz');
            $table->string('z');
            $table->string('workshift');
            $table->string('operator');
            $table->string('maintenance')->nullable();
            $table->string('type_maintenance')->nullable();
            $table->string('operator_maintenance')->nullable();
            $table->string('created_by');
            $table->string('observations')->nullable();
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
        Schema::dropIfExists('bitacora_omff');
    }
}
