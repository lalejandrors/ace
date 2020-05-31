<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemFormulaTratamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_formula_tratamientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('formulaTratamiento_id')->unsigned()->nullable();
            $table->integer('tratamiento_id')->unsigned()->nullable();
            $table->integer('numeroSesiones');
            $table->integer('sesionesRealizadas');
            $table->boolean('activo')->default(1);
            $table->date('fechaPosibleTerminacion');
            $table->text('observacion')->nullable();

            $table->foreign('formulaTratamiento_id')->references('id')->on('formula_tratamientos');
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos');

            $table->timestamps();
        });

        Schema::table('sesions', function (Blueprint $table) {
            $table->foreign('itemFormulaTratamiento_id')->references('id')->on('item_formula_tratamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_formula_tratamientos');
    }
}
