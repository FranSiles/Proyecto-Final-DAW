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
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('imagen');
            $table->integer('pegi');
            $table->string('generoPrincipal')->nullable();
            $table->string('generoSecundario')->nullable();
            $table->string('trailer')->nullable();
            $table->string('desarrollador');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('juegos');
    }
};
