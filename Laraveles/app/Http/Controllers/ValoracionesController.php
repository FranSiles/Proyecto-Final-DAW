<?php

namespace App\Http\Controllers;

use App\Models\Valoraciones;
use Illuminate\Http\Request;

class ValoracionesController extends Controller
{
    public function index()
    {
        $valoraciones = Valoraciones::all();
        return response()->json($valoraciones);
    }

    public function store(Request $request)
    {
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

    public function show(Valoraciones $valoracion)
    {
        return response()->json($valoracion);
    }

    public function update(Request $request, Valoraciones $valoracion)
    {
        $request->validate([
            'codUsuario' => 'exists:usuarios,codUsuario',
            'codJuego' => 'nullable|exists:juegos,codJuego',
            'puntuacion' => 'integer|min:1|max:5',
        ]);

        $valoracion->update($request->all());

        return response()->json(['message' => 'Valoración actualizada correctamente'], 200);
    }

    public function destroy(Valoraciones $valoracion)
    {
        $valoracion->delete();

        return response()->json(['message' => 'Valoración eliminada correctamente'], 200);
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
        $media = Valoraciones::where('codJuego', $codJuego)
                             ->avg('puntuacion');

        return response()->json(['media' => $media]);
    }
}
