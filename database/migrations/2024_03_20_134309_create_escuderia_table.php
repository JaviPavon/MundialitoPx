<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscuderiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuderia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('alias');
            $table->string('descripcion');
            $table->integer('posicion');
            $table->integer('puntos');
            $table->string('logo');
            $table->string('monoplaza');
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
        Schema::dropIfExists('escuderia');
    }
}
