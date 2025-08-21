<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiaPilotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticia_pilotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_noticia')
                  ->nullable()
                  ->constrained('noticias')
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
        Schema::dropIfExists('noticia_pilotos');
    }
}
