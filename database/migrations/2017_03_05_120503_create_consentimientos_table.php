<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsentimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consentimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero');
            $table->integer('historiaClinica_id')->unsigned()->nullable();
            $table->integer('control_id')->unsigned()->nullable();
            $table->integer('sesion_id')->unsigned()->nullable();
            $table->integer('paciente_id')->unsigned();
            $table->text('contenido');
            $table->text('observacion')->nullable();
            $table->integer('user_id')->unsigned();

            $table->foreign('historiaClinica_id')->references('id')->on('historia_clinicas');
            $table->foreign('control_id')->references('id')->on('controls');
            $table->foreign('sesion_id')->references('id')->on('sesions');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('consentimientos');
    }
}
