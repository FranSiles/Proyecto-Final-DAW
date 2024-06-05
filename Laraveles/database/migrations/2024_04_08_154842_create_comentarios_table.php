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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('codComentario');
            $table->unsignedInteger('codUsuario');
            $table->unsignedInteger('codJuego');
            $table->text('texto');
            $table->integer('likes')->nullable();
            $table->timestamps();
            $table->foreign('codUsuario')->references('codUsuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('codJuego')->references('codJuego')->on('juegos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
};
