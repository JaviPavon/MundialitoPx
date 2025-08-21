<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;
    protected $table = "historial";
    protected $fillable = ['numero_jornada', 'id_jugador', 'id_piloto_juego_lider', 'id_piloto_juego'];

    public function jugador() {
        return $this->belongsTo(Jugador::class, 'id_jugador');
    }
    public function piloto_juego() {
        return $this->belongsTo(Piloto_Juego::class, 'id_piloto_juego');
    }
    public function piloto_juego_lider() {
        return $this->belongsTo(Piloto_Juego::class, 'id_piloto_juego_lider');
    }
}
