<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table="usuarios";

    protected $primaryKey = "codUsuario";

    protected $fillable = [
        'codUsuario',
        'nomUsuario',
        'email',
        'administrador',
        'password',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function comentarios(){
        return $this->hasMany(Comentarios::class,"codUsuario");
    }
    public function valoraciones(){
        return $this->hasMany(valoraciones::class,"codUsuario");
    }
    public function juegos(){
        return $this->hasMany(Juegos::class,"codUsuario");
    }
}
