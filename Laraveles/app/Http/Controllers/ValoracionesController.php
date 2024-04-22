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
            'codUsuario' => 'required|exists:usuarios,codUsuario',
            'codJuego' => 'nullable|exists:juegos,codJuego',
            'puntuacion' => 'required|integer|min:1|max:5',
        ]);

        $valoracion = Valoraciones::create($request->all());

        return response()->json(['message' => 'Valoración creada correctamente'], 201);
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
}
        