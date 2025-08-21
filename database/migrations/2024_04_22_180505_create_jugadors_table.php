<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJugadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jugadores', function (Blueprint $table) {
            $table->id();
            $table->integer('puntos')->default(0);
            $table->integer('puesto');
            $table->integer('saldo');
            $table->foreignId('id_liga')
                  ->nullable()
                  ->constrained('ligas')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->foreignId('id_piloto_juego_lider')
                  ->nullable()
                  ->constrained('pilotos_juego')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->foreignId('id_piloto_juego')
                  ->nullable()
                  ->constrained('pilotos_juego')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->foreignId('id_usuario')
                  ->nullable()
                  ->constrained('users')
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
        Schema::dropIfExists('jugadores');
    }
}
