<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario; 

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
        Usuario::create([
            'nomUsuario' => 'Usuario1',
            'correo' => 'usuario1@example.com',
            'contraseña' => bcrypt('password123'), // Asegúrate de cifrar la contraseña
            // Agrega otros campos según tu tabla
        ]);

        Usuario::create([
            'nomUsuario' => 'Usuario2',
            'correo' => 'usuario2@example.com',
            'contraseña' => bcrypt('password123'),
            // Agrega otros campos según tu tabla
        ]);

        // Puedes crear más usuarios aquí según sea necesario
    }
}
