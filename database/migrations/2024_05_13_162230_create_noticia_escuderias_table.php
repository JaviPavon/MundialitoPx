<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiaEscuderiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticia_escuderias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_noticia')
                  ->nullable()
                  ->constrained('noticias')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->foreignId('id_escuderia')
                  ->nullable()
                  ->constrained('escuderia')
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
        Schema::dropIfExists('noticia_escuderias');
    }
}
