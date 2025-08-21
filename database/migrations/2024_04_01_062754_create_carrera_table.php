<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarreraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
            $table->integer('puesto');
            $table->integer('puntos')->default(0);
            $table->boolean('vuelta_rapida')->default(false);
            $table->enum('estado', ['DNF', 'DSQ'])->nullable();
            $table->foreignId('id_circuito')
                  ->nullable()
                  ->constrained('circuitos')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
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
        Schema::dropIfExists('carrera');
    }
}
