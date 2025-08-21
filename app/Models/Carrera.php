<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    public function circuito() {
        return $this->belongsTo(Circuito::class, 'id_circuito');
    }

    public function piloto() {
        return $this->belongsTo(Piloto::class, 'id_piloto');
    }

}
