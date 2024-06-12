<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class juegos extends Model
{
    use HasFactory;
    protected $table="juegos";
    protected $primaryKey = "codJuego";
    protected $fillable = ['codJuego','codUsuario','nombre','descripcion','imagen','pegi','generoPrincipal','generoSecundario','trailer','desarrollador'];
    public function comentarios(){
        return $this->hasMany(Comentarios::class,"codJuego");
    }
    public function valoraciones(){
        return $this->hasMany(Valoraciones::class,"codJuego");
    }
    public function usuarios(){
        return $this->belongsTo(User::class, 'codUsuario');
    }
}
