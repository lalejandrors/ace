<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique;
            $table->string('password');
            $table->enum('tipoId',['CC (Cédula de ciudadanía)','CE (Cédula de extranjería)','PA (Pasaporte)','RC (Registro civil)','TI (Tarjeta de identidad)']);
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefonoFijo')->nullable();
            $table->string('telefonoCelular')->nullable();
            $table->integer('perfil_id')->unsigned();
            $table->boolean('activo')->default(1);
            $table->integer('medico_id')->unsigned();

            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
