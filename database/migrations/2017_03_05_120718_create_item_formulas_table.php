<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_formulas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('formula_id')->unsigned();
            $table->integer('medicamento_id')->unsigned();
            $table->integer('viaMedicamento_id')->unsigned();
            $table->integer('cantidad');
            $table->string('dosisFrecuencia');
            $table->string('horas');
            $table->string('duracion');
            $table->text('observacion')->nullable();

            $table->foreign('formula_id')->references('id')->on('formulas');
            $table->foreign('medicamento_id')->references('id')->on('medicamentos');
            $table->foreign('viaMedicamento_id')->references('id')->on('via_medicamentos');

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
        Schema::dropIfExists('item_formulas');
    }
}
