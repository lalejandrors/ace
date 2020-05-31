<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncapacidadMedicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incapacidad_medicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero');
            $table->integer('historiaClinica_id')->unsigned()->nullable();
            $table->integer('control_id')->unsigned()->nullable();
            $table->integer('sesion_id')->unsigned()->nullable();
            $table->integer('paciente_id')->unsigned();
            $table->date('fechaFin');
            $table->text('observacion')->nullable();
            $table->integer('user_id')->unsigned();

            $table->foreign('historiaClinica_id')->references('id')->on('historia_clinicas');
            $table->foreign('control_id')->references('id')->on('controls');
            $table->foreign('sesion_id')->references('id')->on('sesions');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('incapacidad_medicas_cie10s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('incapacidadMedica_id')->unsigned();
            $table->integer('cie10_id')->unsigned();

            $table->foreign('incapacidadMedica_id')->references('id')->on('incapacidad_medicas');
            $table->foreign('cie10_id')->references('id')->on('cie10s');

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
        Schema::dropIfExists('incapacidad_medicas');
        Schema::dropIfExists('incapacidad_medicas_cie10s');
    }
}
