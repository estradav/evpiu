<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemperatureEmployeePreventionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_prevention_temperature_peer_day', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_day');
            $table->foreign('id_day')->references('id')->on('employee_prevention_days');
            $table->string('temperature');
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
        Schema::dropIfExists('employee_prevention_temperature_peer_day');
    }
}
