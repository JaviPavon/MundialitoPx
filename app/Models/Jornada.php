<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    use HasFactory;
    protected $fillable = ['puntos', 'puesto', 'adelantamientos', 'sanciones', 'amonestaciones', 'id_piloto_juego', 'id_circuito'];

    public function piloto_juego() {
        return $this->belongsTo(Piloto_Juego::class, 'id_piloto_juego');
    }

    public function circuito() {
        return $this->belongsTo(Circuito::class, 'id_circuito');
    }

}
