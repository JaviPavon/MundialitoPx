<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = "comentarios";

    public function noticia(){
        return $this->belongsTo(Noticia::class, 'id_noticia' );
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
