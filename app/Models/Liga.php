<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    use HasFactory;
    protected $fillable = ['estado', 'nombre', 'contraseña_hash'];

    public function jugador(){
        return $this->hasMany(Jugador::class, 'id_liga');
    }

}
