<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticiaEscuderia extends Model
{
    use HasFactory;

    protected $fillable = ['id_noticia', 'id_escuderia'];

    public function escuderia(){
        return $this->belongsTo(Escuderia::class, 'id_escuderia' );
    }

}
