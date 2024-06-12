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
    public function index()
    {
        $juegos = Juegos::all();
        return response()->json($juegos,200);
    }

    public function store(Request $request)
    {
        /* // Validar los datos del formulario
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
        return response()->json(['message' => 'Juego creado correctamente'], 201); */
        /* $codUsuario=$request->input('codUsario'); */
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
        $nombre=$request->input('nombre');
        $descripcion=$request->input('descripcion');
        $pegi=$request->input('pegi');
        $imagen=$request->file('imagen');
        $generoPrincipal=$request->input('generoPrincipal');
        $generoSecundario=$request->input('generoSecundario');
        $trailer=$request->input('trailer');
        $desarrollador=$request->input('desarrollador');
        $juego=juegos::where('nombre',$nombre)->first();
        if(!$juego){
        $ruta=$imagen->store('public');
        $ruta = 'storage/' . str_replace('public/', '', $ruta);
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
    $juego=juegos::find($codJuego); 
    $juegousuario = juegos::where('codJuego', $codJuego)->with('usuarios')->first(); 
    return response()->json([
        'juego' => $juego,
        'usuario'=>$juegousuario->usuarios->nomUsuario
    ],200);
    /* return response()->json($juego,200); */
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

public function destroy($codJuego)
{
    juegos::where('codJuego',$codJuego)->delete();
    // Retornar una respuesta de éxito
    return response()->json(['message' => 'Juego eliminado correctamente'], 200);
}
public function obtenerJuego(Request $request){
    $id=$request->input("codJuego");
    $juego=juegos::find($id);
    return response()->json($juego,200);
}
/* public function anadirJuego(Request $request){
    
    $nombre=$request->input('nombre');
    $descripcion=$request->input('descripcion');
    $pegi=$request->input('pegi');
    $imagen=$request->file('imagen');
    $generoPrincipal=$request->input('generoPrincipal');
    $generoSecundario=$request->input('generoSecundario');
    $trailer=$request->input('trailer');
    $desarrollador=$request->input('desarrollador');
    $ruta=$imagen->store('public');
    $ruta = 'storage/' . str_replace('public/', '', $ruta);
    if($trailer){
        $trailer = 'https://www.youtube.com/embed/' . str_replace('https://www.youtube.com/watch?v=', '', $trailer);
    }
    juegos::create(['nombre'=>$nombre,
                    'descripcion'=>$descripcion,
                    'imagen'=>$ruta,
                    'pegi'=>$pegi,
                    'generoPrincipal'=>$generoPrincipal,
                    'generoSecundario'=>$generoSecundario,
                    'trailer'=>$trailer,
                    'desarrollador'=>$desarrollador
    ]);
    /* 'codJuego','nombre','descripcion','imagen','pegi','generoPrincipal','generoSecundario','trailer','desarrollador' */
/*}*/
public function juegosaleatorios($codJuego){
    $juegos = juegos::where('codJuego', '!=', $codJuego)->inRandomOrder()->take(5)->get();
    return response()->json($juegos,200);
}
public function juegosusuario($codUsuario){
    $juegos= juegos::where('codUsuario',$codUsuario)->get();
    return response()->json($juegos,200);
}
public function mostrarjuegos(){
    $juegos = juegos::with('usuarios')->get();
    return view('listajuegos',['juegos'=>$juegos]);
}
public function borrarjuego($id){
    juegos::where('codJuego',$id)->delete();
        return redirect(route('listajuegos'));
}
}