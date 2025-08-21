<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fantasy extends Model
{
    use HasFactory;
    protected $table = "fantasy";
    protected $fillable = ['en_juego', 'siguiente_circuito'];


    public function circuito() {
        return $this->belongsTo(Circuito::class, 'id_circuito');
    }
}
