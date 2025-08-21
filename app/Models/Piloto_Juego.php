<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piloto_Juego extends Model
{
    use HasFactory;
    protected $table = "pilotos_juego";
    protected $fillable = ['puntos', 'valor', 'id_piloto'];

    public function piloto() {
        return $this->belongsTo(Piloto::class, 'id_piloto');
    }

    public function jornada(){
        return $this->hasMany(Jornada::class, 'id' );
    }

    public function jugador(){
        return $this->hasMany(Jugador::class, 'id' );
    }

    public function historial(){
        return $this->hasMany(Historial::class, 'id' );
    }

}
