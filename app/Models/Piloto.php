<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piloto extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'biografia', 'puntos', 'posicion','foto', 'id_escuderia','id_pais'];


    public function pais() {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    public function escuderia() {
        return $this->belongsTo(Escuderia::class, 'id_escuderia');
    }

    public function carrera(){
        return $this->hasMany(Carrera::class, 'id' );
    }

    public function piloto_juego(){
        return $this->hasMany(Piloto_Juego::class, 'id' );
    }

    public function canal(){
        return $this->hasMany(Canal::class, 'id' );
    }

    public function noticias()
    {
        return $this->belongsToMany(Noticia::class, 'noticia_pilotos', 'id_piloto', 'id_noticia');
    }

}
