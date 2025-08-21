<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circuito extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'alias', 'circuito', 'silueta', 'id_pais'];

    public function pais() {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    public function carrera(){
        return $this->hasMany(Carrera::class, 'id' );
    }

    public function jornada(){
        return $this->hasMany(Jornada::class, 'id' );
    }

    public function fantasy(){
        return $this->hasMany(Fantasy::class, 'id' );
    }
    public function noticia(){
        return $this->hasMany(Noticia::class, 'id' );
    }


}
