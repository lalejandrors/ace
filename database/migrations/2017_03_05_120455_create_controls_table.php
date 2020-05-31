<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero');
            $table->integer('paciente_id')->unsigned();
            $table->integer('acompanante_id')->unsigned()->nullable();

            $table->text('padecimientoActual');

            $table->boolean('astenia')->nullable();
            $table->boolean('adinamia')->nullable();
            $table->boolean('anorexia')->nullable();
            $table->boolean('fiebre')->nullable();
            $table->boolean('perdidaPeso')->nullable();

            $table->text('aparatoDigestivo')->nullable();
            $table->text('aparatoCardiovascular')->nullable();
            $table->text('aparatoRespiratorio')->nullable();
            $table->text('aparatoUrinario')->nullable();
            $table->text('aparatoGenital')->nullable();
            $table->text('aparatoHematologico')->nullable();
            $table->text('sistemaEndocrino')->nullable();
            $table->text('sistemaOsteomuscular')->nullable();
            $table->text('sistemaNervioso')->nullable();
            $table->text('sistemaSensorial')->nullable();
            $table->text('psicosomatico')->nullable();

            $table->text('terapeuticaAnterior')->nullable();

            $table->string('ta');
            $table->string('fc')->nullable();
            $table->string('fr')->nullable();
            $table->string('temp')->nullable();
            $table->string('peso');
            $table->string('talla')->nullable();

            $table->enum('conciencia',['Orientado','Desorientado'])->nullable();
            $table->enum('hidratacion',['Buena','Deshidratado'])->nullable();
            $table->enum('coloracion',['Adecuada','Palidez','Ictérico'])->nullable();
            $table->enum('marcha',['Normal','Anormal'])->nullable();
            $table->text('otrasAlteraciones')->nullable();

            $table->boolean('normocefalo')->nullable();
            $table->enum('cabello',['Bien Implantado','Alopecia'])->nullable();
            $table->enum('pupilas',['Isocóricas','Anisocória'])->nullable();
            $table->enum('faringe',['Normal','Hiperemia','Exudado Purulento'])->nullable();
            $table->enum('amigdalas',['Normales','Hipertróficas','Exudado Purulento'])->nullable();
            $table->enum('nariz',['Fosas Permeables','Obstruidas','Alterada'])->nullable();
            $table->enum('adenomegaliasCabeza',['No Palpables','Submandibulares','Retroauriculares'])->nullable();
            $table->enum('cuello',['Cilíndrico','Tráquea Central','Crecimiento Tiroideo'])->nullable();
            $table->enum('adenomegaliasCuello',['No Palpables','Posteriores','Anteriores','Supraclavicular'])->nullable();
            $table->enum('pulsos',['Palpables','Simétricos','Alterados'])->nullable();
            $table->enum('torax',['Normolíneo','Tonel','Excavado'])->nullable();
            $table->enum('movResp',['Simétricos','Asimétricos'])->nullable();
            $table->enum('camposPulmonares',['Bien Ventilados','Alterado'])->nullable();
            $table->enum('ruidosCardiacos',['Adecuada Frecuencia','Rítmicos','Alterado'])->nullable();
            $table->enum('adenomegaliasAxilares',['No Palpables','Presentes'])->nullable();
            $table->text('adenomegaliasAxilaresDescripcion')->nullable();
            $table->enum('abdomen',['Plano','Globoso','Blando y Depresible','Resistencia','Abdomen en Madera'])->nullable();
            $table->boolean('dolorPalpacion')->nullable();
            $table->text('dolorPalpacionDescripcion')->nullable();
            $table->enum('visceromegalias',['No Palpable','Hepatomegalia','Esplenomegalia'])->nullable();
            $table->enum('peristalsis',['Normal','Alterada'])->nullable();
            $table->text('peristalsisDescripcion')->nullable();
            $table->enum('miembrosSuperiores',['Íntegras','Simétricas','Pulsos Palpables', 'Alteradas'])->nullable();
            $table->enum('miembrosInferiores',['Íntegras','Simétricas','Pulsos Palpables', 'Alteradas'])->nullable();
            $table->text('genitales')->nullable();

            $table->text('impresionDiagnostica');
            $table->text('tratamiento');

            $table->text('observacion')->nullable();
            $table->integer('user_id')->unsigned();

            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('acompanante_id')->references('id')->on('acompanantes');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('controls_cie10s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('control_id')->unsigned();
            $table->integer('cie10_id')->unsigned();

            $table->foreign('control_id')->references('id')->on('controls');
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
        Schema::dropIfExists('controls');
        Schema::dropIfExists('controls_cie10s');
    }
}
