<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->enum('tipo',['Medicina Alternativa','Medicina Ortodoxa']); 
            $table->string('concentracion');
            $table->integer('unidades');
            $table->integer('presentacion_id')->unsigned();
            $table->integer('laboratorio_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('presentacion_id')->references('id')->on('presentacions');
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios');
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
        Schema::dropIfExists('medicamentos');
    }
}
