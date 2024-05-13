<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    use HasFactory;

    protected $fillable = [
        'codUsuario',
        'codJuego',
        'texto',
        'likes',
        'dislike',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'codUsuario');
    }

    public function juego()
    {
        return $this->belongsTo(Juegos::class, 'codJuego');
    }
}
