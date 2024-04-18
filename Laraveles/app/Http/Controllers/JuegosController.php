<?php

namespace App\Http\Controllers;

use App\Models\juegos;
use Illuminate\Http\Request;

class JuegosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $juegos = Juegos::all();
        return response()->json($juegos);
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pegi' => 'required|integer',
            'generoPrincipal' => 'nullable|string',
            'generoSecundario' => 'nullable|string',
            'trailer' => 'nullable|string',
            'desarrollador' => 'required|string',
        ]);

        // Procesar la imagen si se ha cargado
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        // Crear un nuevo objeto Juegos con los datos del formulario
        $juego = new Juegos([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'imagen' => $imageName, // Nombre de la imagen guardada
            'pegi' => $request->input('pegi'),
            'generoPrincipal' => $request->input('generoPrincipal'),
            'generoSecundario' => $request->input('generoSecundario'),
            'trailer' => $request->input('trailer'),
            'desarrollador' => $request->input('desarrollador'),
        ]);

        // Guardar el juego en la base de datos
        $juego->save();

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Juego creado correctamente'], 201);
    }

    public function show(Juegos $juego)
{
    // Retorna los detalles del juego en formato JSON
    return response()->json($juego);
}

public function edit(Juegos $juego)
{
    // Retorna la vista para editar un juego (si es una aplicación web)
}

public function update(Request $request, Juegos $juego)
{
    // Validar los datos del formulario
    $request->validate([
        'nombre' => 'required',
        'descripcion' => 'required',
        'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'pegi' => 'required|integer',
        'generoPrincipal' => 'nullable|string',
        'generoSecundario' => 'nullable|string',
        'trailer' => 'nullable|string',
        'desarrollador' => 'required|string',
    ]);

    // Actualizar los datos del juego con los datos del formulario
    $juego->update([
        'nombre' => $request->input('nombre'),
        'descripcion' => $request->input('descripcion'),
        'pegi' => $request->input('pegi'),
        'generoPrincipal' => $request->input('generoPrincipal'),
        'generoSecundario' => $request->input('generoSecundario'),
        'trailer' => $request->input('trailer'),
        'desarrollador' => $request->input('desarrollador'),
    ]);

    // Procesar la imagen si se ha cargado
    if ($request->hasFile('imagen')) {
        $image = $request->file('imagen');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $juego->imagen = $imageName;
        $juego->save();
    }

    // Retornar una respuesta de éxito
    return response()->json(['message' => 'Juego actualizado correctamente'], 200);
}

public function destroy(Juegos $juego)
{
    // Eliminar el juego de la base de datos
    $juego->delete();

    // Retornar una respuesta de éxito
    return response()->json(['message' => 'Juego eliminado correctamente'], 200);
}
}