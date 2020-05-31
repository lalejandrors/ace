<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipoId',['CC (Cédula de ciudadanía)','CE (Cédula de extranjería)','PA (Pasaporte)','RC (Registro civil)','TI (Tarjeta de identidad)']);
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fechaNacimiento');
            $table->string('telefonoFijo')->nullable();
            $table->string('telefonoCelular')->nullable();
            $table->string('email')->nullable();
            $table->enum('genero',['Masculino','Femenino','Otro']);
            $table->boolean('hijos');
            $table->integer('ciudad_id')->unsigned();
            $table->enum('ubicacion',['Rural','Urbano']);
            $table->string('direccion');
            $table->enum('estadoCivil',['Soltero(a)','Viudo(a)','Casado(a)','Unión Libre','Divorciado']);
            $table->string('ocupacion');
            $table->integer('eps_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('ciudad_id')->references('id')->on('ciudads');
            $table->foreign('eps_id')->references('id')->on('eps');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

         Schema::create('pacientes_cie10s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned();
            $table->integer('cie10_id')->unsigned();

            $table->foreign('paciente_id')->references('id')->on('pacientes');
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
        Schema::dropIfExists('pacientes');
        Schema::dropIfExists('pacientes_cie10s');
    }
}
