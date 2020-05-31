<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoCentrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_centros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razonSocial');
            $table->string('nit');
            $table->string('registroMedico');
            $table->string('email');
            $table->string('direccion');
            $table->string('telefonos');
            $table->string('linkWeb')->nullable();
            $table->string('linkFacebook')->nullable();
            $table->string('linkTwitter')->nullable();
            $table->string('linkYoutube')->nullable();
            $table->string('linkInstagram')->nullable();
            $table->text('infoAdicional')->nullable();
            $table->text('path');

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
        Schema::dropIfExists('info_centros');
    }
}
