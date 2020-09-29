<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityInOperationToInspectionWorkCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspection_work_centers', function (Blueprint $table) {
            $table->bigInteger('quantity_operation')->after('production_order')->default(0);

            $table->dropColumn(['cause']);

            $table->unsignedBigInteger('cause_id')->nullable()->after('non_conforming_quantity');
            $table->foreign('cause_id')->references('id')->on('causes_to_inspection_work_centers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspection_work_centers', function (Blueprint $table) {
            //
        });
    }
}
