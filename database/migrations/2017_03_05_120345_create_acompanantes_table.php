<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcompanantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acompanantes', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipoId',['CC (Cédula de ciudadanía)','CE (Cédula de extranjería)','PA (Pasaporte)','RC (Registro civil)','TI (Tarjeta de identidad)']);
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefonoFijo');
            $table->string('telefonoCelular');

            $table->timestamps();
        });

        Schema::create('pacientes_acompanantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned();
            $table->integer('acompanante_id')->unsigned();
            $table->string('parentesco');

            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('acompanante_id')->references('id')->on('acompanantes');

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
        Schema::dropIfExists('acompanantes');
        Schema::dropIfExists('pacientes_acompanantes');
    }
}
