<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned();
            $table->integer('citaTipo_id')->unsigned();
            $table->integer('tratamiento_id')->unsigned()->nullable();
            $table->datetime('fechaHoraInicio');
            $table->datetime('fechaHoraFin');
            $table->text('observacion')->nullable();
            $table->enum('estado',['Creada','Confirmada','Asistida'])->default('Creada');
            $table->integer('user_id')->unsigned();

            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('citaTipo_id')->references('id')->on('cita_tipos');
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('agendas');
    }
}
