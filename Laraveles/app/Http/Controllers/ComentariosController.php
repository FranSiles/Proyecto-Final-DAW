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
        // Validar los datos de entrada si es necesario
        $request->validate([
            'texto' => 'required|string',
            'codUsuario' => 'required|integer',
            'codJuego' => 'required|integer',
        ]);

        // Verificar si el usuario ya ha comentado este juego
        $existingComment = Comentarios::where('codUsuario', $request->input('codUsuario'))
                                      ->where('codJuego', $request->input('codJuego'))
                                      ->first();
        if ($existingComment) {
            return response()->json(['error' => 'Ya has comentado este juego.'], 400);
        }

        // Crear el comentario usando asignación en masa
        $comentario = new Comentarios([
            'texto' => $request->input('texto'),
            'codUsuario' => $request->input('codUsuario'),
            'codJuego' => $request->input('codJuego'),
        ]);

        $comentario->save(); // Guarda el comentario en la base de datos

        return response()->json(['message' => 'Comentario creado exitosamente'], 201);
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
        ]);

        $comentario->update($request->all());

        return response()->json(['message' => 'Comentario actualizado correctamente'], 200);
    }

    public function destroy(Comentarios $comentario)
    {
        $comentario->delete();

        return response()->json(['message' => 'Comentario eliminado correctamente'], 200);
    }

    public function getComentarios($id)
    {
        $comentarios = Comentarios::where('codJuego', $id)
            ->with(['usuario' => function ($query) {
                $query->select('codUsuario', 'foto', 'nomUsuario'); // Asumiendo que 'foto' es el nombre de la columna en la tabla 'usuarios'
            }])
            ->get(['codComentario', 'codUsuario', 'codJuego', 'texto', 'likes']);

        if ($comentarios->isEmpty()) {
            return response()->json(['message' => 'No comments found'], 404);
        }

        return response()->json($comentarios);
    }
}
