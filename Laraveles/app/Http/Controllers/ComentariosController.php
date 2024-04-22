<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    public function index()
    {
        $comentarios = Comentarios::all();
        return response()->json($comentarios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codUsuario' => 'required|exists:usuarios,codUsuario',
            'codJuego' => 'nullable|exists:juegos,codJuego',
            'texto' => 'required',
            'likes' => 'nullable|integer',
            'dislike' => 'nullable|integer',
        ]);

        $comentario = Comentarios::create($request->all());

        return response()->json(['message' => 'Comentario creado correctamente'], 201);
    }

    public function show(Comentarios $comentario)
    {
        return response()->json($comentario);
    }

    public function update(Request $request, Comentarios $comentario)
    {
        $request->validate([
            'codUsuario' => 'exists:usuarios,codUsuario',
            'codJuego' => 'nullable|exists:juegos,codJuego',
            'likes' => 'nullable|integer',
            'dislike' => 'nullable|integer',
        ]);

        $comentario->update($request->all());

        return response()->json(['message' => 'Comentario actualizado correctamente'], 200);
    }

    public function destroy(Comentarios $comentario)
    {
        $comentario->delete();

        return response()->json(['message' => 'Comentario eliminado correctamente'], 200);
    }
}
