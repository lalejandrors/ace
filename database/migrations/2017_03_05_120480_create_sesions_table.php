<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSesionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero');
            $table->integer('paciente_id')->unsigned();
            $table->integer('acompanante_id')->unsigned()->nullable();
            $table->integer('itemFormulaTratamiento_id')->unsigned();
            $table->integer('numeroVez');
            $table->text('observacion');
            $table->integer('user_id')->unsigned();

            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('acompanante_id')->references('id')->on('acompanantes');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
        });

        Schema::create('sesions_cie10s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sesion_id')->unsigned();
            $table->integer('cie10_id')->unsigned();

            $table->foreign('sesion_id')->references('id')->on('sesions');
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
        Schema::dropIfExists('sesions');
        Schema::dropIfExists('sesions_cie10s');
    }
}
