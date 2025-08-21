<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = "videos";
    protected $fillable = ['nombre', 'enlace','fecha_publicación', 'id_canal'];

    public function canal() {
        return $this->belongsTo(Canal::class, 'id_canal');
    }
}
