<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToEmployeePreventionDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_prevention_days', function (Blueprint $table) {
            $table->boolean('question_1')->default('0')->after('time_exit');
            $table->boolean('question_2')->default('0')->after('question_1');
            $table->boolean('question_3')->default('0')->after('question_2');
            $table->boolean('question_4')->default('0')->after('question_3');
            $table->boolean('question_5')->default('0')->after('question_4');
            $table->boolean('question_6')->default('0')->after('question_5');
            $table->string('notes')->nullable(true)->after('question_6');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_prevention_days', function (Blueprint $table) {
            //
        });
    }
}
