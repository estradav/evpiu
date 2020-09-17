<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkeyToCodMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cod_materials', function (Blueprint $table) {
            $table->unsignedBigInteger('id_material')->nullable()->after('id');
            $table->foreign('id_material')->references('id')->on('materiales');
            $table->dropColumn(['cod', 'name', 'abreviatura','usuario']);

            $table->unsignedBigInteger('user_id')->nullable()->after('id_material');
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
        Schema::table('cod_materiales', function (Blueprint $table) {
            //
        });
    }
}
