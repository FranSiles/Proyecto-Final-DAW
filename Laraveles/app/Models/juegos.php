<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class juegos extends Model
{
    use HasFactory;
    protected $fillable = ['codJuego','nombre','descripcion','imagen','pegi','generoPrincipal','generoSecundario','trailer','desarrollador'];

}
