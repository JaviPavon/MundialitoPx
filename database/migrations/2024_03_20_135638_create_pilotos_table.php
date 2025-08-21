<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilotos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('biografia');
            $table->integer('puntos');
            $table->integer('posicion');
            $table->integer('dorsal');
            $table->string('foto');
            $table->foreignId('id_escuderia')
                  ->nullable()
                  ->constrained('escuderia')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->foreignId('id_pais')
                  ->nullable()
                  ->constrained('pais')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
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
        Schema::dropIfExists('pilotos');
    }
}
