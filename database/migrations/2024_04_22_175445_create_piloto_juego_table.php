<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilotoJuegoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilotos_juego', function (Blueprint $table) {
            $table->id();
            $table->integer('puntos')->default(0);
            $table->integer('valor');
            $table->foreignId('id_piloto')
                  ->nullable()
                  ->constrained('pilotos')
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
        Schema::dropIfExists('pilotos_juego');
    }
}
