<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Usuarios; 
use Illuminate\Support\Facades\DB ;

class JuegosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('juegos')->insert([
            'nombre' => 'Nombre del juego',
            'descripcion' => 'Descripción del juego',
            'imagen' => 'url_de_la_imagen.jpg',
            'pegi' => 18,
            'generoPrincipal' => 'Género principal del juego',
            'generoSecundario' => 'Género secundario del juego',
            'trailer' => 'url_del_trailer.mp4',
            'desarrollador' => 'Nombre del desarrollador del juego',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
