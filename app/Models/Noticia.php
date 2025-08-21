<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function circuito()
    {
        return $this->belongsTo(Circuito::class, 'id_circuito');
    }

    public function pilotos()
    {
        return $this->belongsToMany(Piloto::class, 'noticia_pilotos', 'id_noticia', 'id_piloto');
    }
    public function escuderias()
    {
        return $this->belongsToMany(Escuderia::class, 'noticia_escuderias', 'id_noticia', 'id_escuderia');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_noticia');
    }
}
