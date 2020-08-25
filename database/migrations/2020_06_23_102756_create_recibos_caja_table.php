<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibosCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos_caja', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->string('nit');
            $table->string('total');
            $table->string('comments')->nullable();
            $table->string('created_by');
            $table->date('fecha_pago');
            $table->string('cuenta_pago');
            $table->string('state');
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
        Schema::dropIfExists('recibos_caja');
    }
}
