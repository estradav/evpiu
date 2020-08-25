<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogModificationsClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_modifications_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_cliente');
            $table->string('campo_cambiado');
            $table->string('usuario');
            $table->string('justificacion');
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
        Schema::dropIfExists('log_modifications_clients');
    }
}
