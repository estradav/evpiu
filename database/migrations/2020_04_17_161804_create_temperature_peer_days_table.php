<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemperaturePeerDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_prevention_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_employee');
            $table->foreign('id_employee')->references('id')->on('employee_prevention');
            $table->string('time_enter');
            $table->string('time_exit');
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
        Schema::dropIfExists('employee_prevention_days');
    }
}
