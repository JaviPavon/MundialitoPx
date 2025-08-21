<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    use HasFactory;

    protected $table = "canales";
    protected $fillable = ['nombre', 'enlace', 'id_piloto'];

    public function piloto() {
        return $this->belongsTo(Piloto::class, 'id_piloto');
    }

    public function video(){
        return $this->hasMany(Video::class, 'id' );
    }
}
