<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticiaPiloto extends Model
{
    use HasFactory;

    protected $fillable = ['id_noticia', 'id_piloto'];

    public function piloto(){
        return $this->belongsTo(Piloto::class, 'id_piloto' );
    }
}
