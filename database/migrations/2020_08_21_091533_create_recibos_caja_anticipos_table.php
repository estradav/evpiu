<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibosCajaAnticiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos_caja_anticipos', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->integer('nit');
            $table->float('total_paid');
            $table->date('date_paid');
            $table->integer('account_paid');
            $table->longText('details')->nullable();
            $table->integer('state');
            $table->integer('rc_dms')->default(null);

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');

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
        Schema::dropIfExists('recibos_caja_anticipos');
    }
}
