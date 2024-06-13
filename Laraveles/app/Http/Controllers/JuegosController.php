<?php

namespace App\Http\Controllers;

use App\Models\juegos;
use App\Rules\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JuegosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /* Funcionalidades de mi api con juegos */
    public function index()
    {
        /* Obtencion de todos los juegos */
        $juegos = Juegos::all();
        return response()->json($juegos,200);
    }

    public function store(Request $request)
    {
        /* Validacion del registro */
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|min:100|max:500',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pegi' => 'required|string',
            'generoPrincipal' => 'required|string',
            'generoSecundario' => 'nullable|string',
            'trailer' => ['nullable','string',new Video],
            'desarrollador' => 'required|string',
        ]);
        /* Obtencion de valores de mi peticon a la api */
        $nombre=$request->input('nombre');
        $descripcion=$request->input('descripcion');
        $pegi=$request->input('pegi');
        $imagen=$request->file('imagen');
        $generoPrincipal=$request->input('generoPrincipal');
        $generoSecundario=$request->input('generoSecundario');
        $trailer=$request->input('trailer');
        $desarrollador=$request->input('desarrollador');
        $juego=juegos::where('nombre',$nombre)->first();
        /* comporbacion de que el juego existe */
        if(!$juego){
        $ruta=$imagen->store('public');
        $ruta = 'storage/' . str_replace('public/', '', $ruta);
        /* Comprobacion de que se a enviado un trailer */
        if($trailer){
            $trailer = 'https://www.youtube.com/embed/' . str_replace('https://www.youtube.com/watch?v=', '', $trailer);
        }
        juegos::create(['codUsuario' => Auth::user()->codUsuario,
                        'nombre'=>$nombre,
                        'descripcion'=>$descripcion,
                        'imagen'=>$ruta ,
                        'pegi'=>$pegi,
                        'generoPrincipal'=>$generoPrincipal,
                        'generoSecundario'=>$generoSecundario,
                        'trailer'=>$trailer,
                        'desarrollador'=>$desarrollador
        ]);
    }else{
        return response()->json(["status" => "error","message" => "Este juego ya existe"], 422);
    }
    }

    public function show($codJuego)
{
    /* Mostrar los datos de un juego especifico */
    $juego=juegos::find($codJuego); 
    $juegousuario = juegos::where('codJuego', $codJuego)->with('usuarios')->first(); 
    return response()->json([
        'juego' => $juego,
        'usuario'=>$juegousuario->usuarios->nomUsuario
    ],200);
    /* return response()->json($juego,200); */
}

public function destroy($codJuego)
{
    /* Eliminar un juego en especifico */
    juegos::where('codJuego',$codJuego)->delete();
    // Retornar una respuesta de éxito
    return response()->json(['message' => 'Juego eliminado correctamente'], 200);
}

public function juegosaleatorios($codJuego){
    /* Mostrar juegos que estan almacenados en mi base de datos salvo el que se envia */
    $juegos = juegos::where('codJuego', '!=', $codJuego)->inRandomOrder()->take(5)->get();
    return response()->json($juegos,200);
}
public function juegosusuario($codUsuario){
    /* Mostrar los juegos de los usuarios */
    $juegos= juegos::where('codUsuario',$codUsuario)->get();
    return response()->json($juegos,200);
}
/* funicones para el administrador  */
public function mostrarjuegos(){
    /* Mostrar todos los juegos al administrador */
    $juegos = juegos::with('usuarios')->get();
    return view('listajuegos',['juegos'=>$juegos]);
}
public function borrarjuego($id){
    /* Borrrar los juegos para el administrador */
    juegos::where('codJuego',$id)->delete();
        return redirect(route('listajuegos'));
}
}