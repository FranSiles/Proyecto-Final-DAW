<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('juegos', function (Blueprint $table) {
            $table->increments('codJuego');
            $table->unsignedInteger('codUsuario');
            $table->string('nombre')->unique();
            $table->text('descripcion');
            $table->string('imagen');
            $table->integer('pegi');
            $table->string('generoPrincipal');
            $table->string('generoSecundario')->nullable();
            $table->string('trailer')->nullable();
            $table->string('desarrollador');
            $table->timestamps();
            $table->foreign('codUsuario')->references('codUsuario')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('juegos');
    }
};
