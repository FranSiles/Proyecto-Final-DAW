<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoraciones extends Model
{
    use HasFactory;

    protected $table="valoraciones";

    protected $primaryKey = "codValoracion";

    protected $fillable = [
        'codValoracion',
        'codUsuario',
        'codJuego',
        'puntuacion',
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
