<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'bandera'];

    

    public function escuderia(){
        return $this->hasMany(Escuderia::class, 'id' );
    }

    public function piloto(){
        return $this->hasMany(Piloto::class, 'id' );
    }

    public function circuito(){
        return $this->hasMany(Circuito::class, 'id' );
    }
}
