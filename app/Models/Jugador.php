<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;
    protected $table = "jugadores";
    protected $fillable = ['puntos', 'puesto', 'saldo', 'id_liga', 'id_piloto_juego_lider', 'id_piloto_juego', 'id_usuario'];

    public function piloto_juego() {
        return $this->belongsTo(Piloto_Juego::class, 'id_piloto_juego');
    }
    public function piloto_juego_lider() {
        return $this->belongsTo(Piloto_Juego::class, 'id_piloto_juego_lider');
    }
    public function usuario() {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function liga() {
        return $this->belongsTo(Liga::class, 'id_liga');
    }
    public function historial(){
        return $this->hasMany(Historial::class, 'id' );
    }
}
