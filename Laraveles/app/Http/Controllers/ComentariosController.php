<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    /* Funcionalidades de la api */
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
    
    public function getComentarios($id)
    {
        $comentarios = Comentarios::where('codJuego', $id)
            ->with(['usuario' => function ($query) {
                $query->select('codUsuario', 'foto','nomUsuario'); // Asumiendo que 'fotoPerfil' es el nombre de la columna en la tabla 'usuarios'
            }])
            ->get(['codComentario', 'codUsuario', 'codJuego', 'texto', 'likes']);
    
        if ($comentarios->isEmpty()) {
            return response()->json(['message' => 'No comments found'], 404);
        }
    
        return response()->json($comentarios);
    }
    /* Funcionalidades de la web */
    public function mostrarcomentarios(){
        /* Mostrar los comentarios */
        $comentarios=Comentarios::with('juego','usuario')->get();
        return view('listacomentarios',['comentarios'=>$comentarios]);
    }
    public function borrarcomentarios($id){
        /* Borrar los comentarios */
        Comentarios::where('codComentario',$id)->delete();
        return redirect(route('listacomentarios'));
    }
}