<?php

namespace App\Http\Controllers;

use App\Models\Valoraciones;
use Illuminate\Http\Request;


class ValoracionesController extends Controller
{
    /* Funcionalidades de la api */
    public function store(Request $request)
    {
        /* Validaciones */
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'codUsuario' => 'required|exists:usuarios,codUsuario',
            'codJuego' => 'required|exists:juegos,codJuego',
        ]);

        // Verificar si el usuario ya ha valorado este juego
        $existingRating = Valoraciones::where('codUsuario', $request->input('codUsuario'))
                                      ->where('codJuego', $request->input('codJuego'))
                                      ->first();
        if ($existingRating) {
            return response()->json(['error' => 'Ya has valorado este juego.'], 400);
        }

        // Crear la valoración usando asignación en masa
        $valoracion = new Valoraciones([
            'puntuacion' => $request->input('puntuacion'),
            'codUsuario' => $request->input('codUsuario'),
            'codJuego' => $request->input('codJuego'),
        ]);

        $valoracion->save(); // Guarda la valoración en la base de datos

        return response()->json(['message' => 'Valoración guardada con éxito'], 201);
    }

    public function getValoraciones($id)
{
    $valoraciones = Valoraciones::where('codJuego', $id)
        ->with(['usuario' => function ($query) {
            $query->select('codUsuario', 'foto', 'nomUsuario'); // Asumiendo que 'foto' y 'nomUsuario' son nombres de columnas en la tabla 'usuarios'
        }])
        ->get(['codValoracion', 'codUsuario', 'codJuego', 'puntuacion']);

    if ($valoraciones->isEmpty()) {
        return response()->json(['message' => 'No ratings found'], 404);
    }

    return response()->json($valoraciones);
}

public function obtenerValoracionesJuego($codJuego)
{
    $valoraciones = Valoraciones::where('codJuego', $codJuego)->get();

    $counts = [0, 0, 0, 0, 0];
    foreach ($valoraciones as $valoracion) {
        $counts[$valoracion->puntuacion - 1]++;
    }

    return response()->json(['counts' => $counts]);

}
public function mediaValoracionesJuego($codJuego)
    {
        $media = Valoraciones::where('codJuego', $codJuego)->avg('puntuacion');
        $mediaRedondeada = round($media, 1);
        return response()->json(['media' => $mediaRedondeada]);
    }
    /* Funcionalidades de la web */
public function mostrarvaloraciones(){
    $valoraciones=Valoraciones::with('juego','usuario')->get();
    return view('listavaloraciones',['valoraciones'=>$valoraciones]);
}
public function borrarvaloraciones($id){
    Valoraciones::where('codValoracion',$id)->delete();
        return redirect(route('listavaloraciones'));
}
}