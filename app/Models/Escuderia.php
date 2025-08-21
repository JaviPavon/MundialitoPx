<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuderia extends Model
{
    use HasFactory;
    protected $table = "escuderia";
    protected $fillable = ['posicion', 'nombre', 'alias', 'descripcion', 'puntos', 'id_pais', 'logo', 'monoplaza'];


    public function pais() {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    public function noticias()
    {
        return $this->belongsToMany(Noticia::class, 'noticia_escuderias', 'id_escuderia', 'id_noticia');
    }


}

