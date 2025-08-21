<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornadas', function (Blueprint $table) {
            $table->id();
            $table->integer('puntos')->default(0);
            $table->integer('puesto');
            $table->integer('adelantamientos');
            $table->integer('sancion3sec');
            $table->integer('sancion5sec');
            $table->integer('amonestaciones');
            $table->boolean('qually2')->default(false);
            $table->boolean('qually3')->default(false);
            $table->foreignId('id_piloto_juego')
                  ->nullable()
                  ->constrained('pilotos_juego')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->foreignId('id_circuito')
                  ->nullable()
                  ->constrained('circuitos')
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
        Schema::dropIfExists('jornadas');
    }
}
