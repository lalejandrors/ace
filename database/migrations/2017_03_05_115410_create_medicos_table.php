<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('especialidad')->nullable();
            $table->string('registroMedico')->nullable();
            $table->string('email')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('medico_id')->references('id')->on('medicos');
        });

        Schema::create('users_medicos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('medico_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('medico_id')->references('id')->on('medicos');

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
        Schema::dropIfExists('medicos');
        Schema::dropIfExists('users_medicos');
    }
}
