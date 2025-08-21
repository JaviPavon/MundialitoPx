<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_jornada');
            $table->foreignId('id_jugador')
                  ->nullable()
                  ->constrained('jugadores')
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
        Schema::dropIfExists('historial');
    }
}
