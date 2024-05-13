<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Usuarios; 
use Illuminate\Support\Facades\DB ;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creamos algunos usuarios ficticios
        User::create([
            'nomUsuario' => 'Usuario1',
            'email' => 'usuario1@example.com',
            'password' => bcrypt('password123'), // Asegúrate de cifrar la contraseña
            // Agrega otros campos según tu tabla
        ]);

        User::create([
            'nomUsuario' => 'Usuario2',
            'email' => 'usuario2@example.com',
            'password' => bcrypt('password123'),
            // Agrega otros campos según tu tabla
        ]);

        // Puedes crear más usuarios aquí según sea necesario
    }
}
