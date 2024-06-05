<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JuegosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("juegos")->insert(["CodUsuario"=>1,
                                    "nombre"=>"Elden ring",
                                    "descripcion"=>"Elden Ring tiene lugar en las Tierras Intermedias, un continente ficticio gobernado por diferentes semidioses. Anteriormente estaba gobernado por la Reina Marika la Eterna, la cual actuaba como guardiana del Círculo de Elden, una poderosa fuerza que se manifiesta como el concepto físico del orden. Cuando Marika destruyó el Círculo de Elden y desapareció, sus hijos, todos semidioses, empezaron a guerrear para obtener fragmentos del Círculo en la Guerra de la Devastación. Cada semidios posee un fragmento del Círculo, llamado Gran Runa, la cual les proporciona fuerza.",
                                    "imagen"=>"storage/Eldenring.jpg",
                                    "pegi"=>16,
                                    "generoPrincipal"=>"Rol",
                                    "generoSecundario"=>"Accion",
                                    "trailer"=>"https://www.youtube.com/embed/CptaXqVY6-E",
                                    "desarrollador"=>"FromSoftware"]);
        DB::table("juegos")->insert(["CodUsuario"=>2,
                                    "nombre"=>"The legend of zelda breath of the wild",
                                    "descripcion"=>"Diez mil años antes del comienzo del juego, Hyrule es una civilización avanzada que construyó cuatro enormes máquinas con formas de animales llamadas bestias divinas y una legión de guardianes para protegerse de Ganon. Cuando Ganon regresó, fue derrotado por una princesa con la ayuda de los cuatro campeones y un caballero.",
                                    "imagen"=>"storage/zelda.jpg",
                                    "pegi"=>12,
                                    "generoPrincipal"=>"Rol",
                                    "trailer"=>"https://www.youtube.com/embed/ofH5ptn5w-A",
                                    "desarrollador"=>"Nintendo"]);
        DB::table("juegos")->insert(["CodUsuario"=>1,
                                    "nombre"=>"Assassin's Creed Valhalla",
                                    "descripcion"=>"En el año 873 d. C., la guerra y el hacinamiento llevaron a Eivor a liderar a su clan de vikingos para que abandonaran Noruega. Se instalan en la Inglaterra medieval como parte de la expansión vikinga en toda Europa. Esto los pone en conflicto con los reinos anglosajones de Wessex, Northumbria, Estanglia y Mercia. El clan de Eivor enfrentará fuerzas lideradas por los líderes de estos reinos, incluido Alfredo el Grande, el rey de Wessex. Es durante este tiempo que Eivor se encuentra con los Ocultos y se une a su lucha contra la Orden de los Antiguos. Las ciudades explorables incluyen Winchester, Londres y York, así como partes de Noruega, América, Irlanda y Francia.",
                                    "imagen"=>"storage/AssassinsCreedValhalla.png",
                                    "pegi"=>18,
                                    "generoPrincipal"=>"Accion",
                                    "generoSecundario"=>"Aventura",
                                    "trailer"=>"https://www.youtube.com/embed/ylQoXLLMim4",
                                    "desarrollador"=>"Ubisoft"]);
        DB::table("juegos")->insert(["CodUsuario"=>2,
                                    "nombre"=>"Geometry dash",
                                    "descripcion"=>"Juego de cubitos y saltar",
                                    "imagen"=>"storage/geometrydash.jpg",
                                    "pegi"=>3,
                                    "generoPrincipal"=>"Plataforma",
                                    "desarrollador"=>"Robtop"]);
    }
}
