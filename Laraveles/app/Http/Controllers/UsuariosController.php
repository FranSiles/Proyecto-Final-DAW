<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /* Funcionalidades de mi usuario en mi api */
    public function show($codUsuario)
    {
        /* Mostrar datos de un usuario especifico */
        $usuario=User::find($codUsuario);
        return response()->json($usuario);
    }
    public function update(Request $request, $codUsuario){
        /* REcogida de datos del usuario */
    $email=$request->input('email');
    $nomUsuario=$request->input('nomUsuario');
    $password=$request->input('password');
    /* validaciones  */
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        'nomUsuario'=>'required|string',
    ]);
    /* Confirmacion de que el nombre de usuario no exista ya */
    $nombre=User::where('nomUsuario',$nomUsuario)->first();
    if(!$nombre){
        User::where('codUsuario' , $codUsuario)->update(['email'=>$email,
                                                        'nomUsuario'=>$nomUsuario,
                                                        'password'=>Hash::make($password)]);
        // Cerramos las sesion del usuario
        $usuarioeliminotoken = $request->user();
        $usuarioeliminotoken->currentAccessToken()->delete();
        return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
    }else{
        return response()->json(["status" => "error","message" => "El nombre del usuario ya existe"], 422);
    }
}
    public function destroy($id,Request $request){
        /* Elimina el usuario y consigo sus juegos y valoraciones */
        $usuario = User::where('codUsuario', $id)->first();
        $usuarioeliminotoken = $request->user();
        $usuarioeliminotoken->currentAccessToken()->delete();
        $usuario->delete();
        /* return response()->json(['message' => 'Usuario eliminado correctamente'], 200); */
    }
    public function registro(Request $request){
        /* Recogida de datos del formulario */
        $email=$request->input('email');
        $password=$request->input('password');
        $nomUsuario=$request->input('nombre');
        $foto=$request->file('foto');
        /* Validaciones */
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'nombre'=>'required|string',
            'foto'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $usuario=User::where('email',$email)->first();
        $nombre=User::where('nomUsuario',$nomUsuario)->first();
        /* Comprobacion de que el usuario que se crea no este repetido el correo o el nombre en la base de datos */
        if(!$usuario && !$nombre){
            /* Comprobacion de si ha subido foto si es asi se le pondra la foto que ha subido sino se le pondra una foto preestablecida */
            if($foto){
                $imagen = $foto;
                $ruta=$imagen->store('public');
                $ruta = 'storage/' . str_replace('public/', '', $ruta);
                User::create([
                    'nomUsuario' => $nomUsuario,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'foto' => $ruta,
                    'administrador'=>"no"
                ]);
            }else{
                $ruta="storage/fotoperfil.webp";
                User::create([
                    'nomUsuario' => $nomUsuario,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'foto'=> $ruta,
                    'administrador'=>"no"]);
            }
        }else{
            return response()->json(["status" => "error","message" => "Este usuario ya existe"], 422);
        }
    }
    public function cambiarfoto(Request $request){
        /* Validacion de cambiar la foto */
        $request->validate([
            'foto'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        /* Hacer un update para cambiar la foto */
        $foto=$request->file('foto');
        $ruta=$foto->store('public');
        $ruta = 'storage/' . str_replace('public/', '', $ruta);
        User::where('codUsuario',Auth::user()->codUsuario)->update(['foto'=>$ruta]);
        return response()->json(['message' => 'Foto de usuario actualizada correctamente'], 200);
    }
    public function obtenerComentariosYValoraciones($codUsuario)
    {
        //encontrar el usuario
        $usuario = User::find($codUsuario);

        // Obtén los comentarios y valoraciones del usuario
        $comentarios =$usuario->comentarios;
        $valoraciones =$usuario->valoraciones;
        $resultados = [];

        /* Ordenacion de los comentarios y valoraciones en un array */
        foreach ($comentarios as $comentario) {
            $resultados[] = [
                'codJuego' => $comentario->codJuego,
                'comentario' => $comentario->texto,
                'valoracion' => null
            ];
        }
    
        foreach ($valoraciones as $valoracion) {
            $index = array_search($valoracion->codJuego, array_column($resultados, 'codJuego'));
    
            if ($index !== false) {
                $resultados[$index]['valoracion'] = $valoracion->puntuacion;
            } else {
                $resultados[] = [
                    'codJuego' => $valoracion->codJuego,
                    'comentario' => null,
                    'valoracion' => $valoracion->textoValoracion
                ];
            }
        }
        return response()->json($resultados,200);
    }
    /* Funcionalidades de la web */
    public function login(Request $request){
        /* Validaciones */
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        /* Comprobacion de un usuario si existe y es administrador sino este usuario no existe  */
        if (Auth::attempt($request->only("email","password"))):
            if(Auth::user()->administrador=="si"){
                $request->session()->regenerate();
                return redirect(route('dashboard'));
            }
            return redirect()->back()->withErrors(['error' => 'Este usuario no es administrador']);
            return redirect(route('welcome'));
        else:
            return redirect()->back()->withErrors(['error' => 'Este usuario no existe']);
        endif ;
    }
    public function mostrarusuarios(){
        /* PAra mostrar todos los usuarios */
        $usuarios=User::all();
        return view('dashboard',['usuarios'=>$usuarios]);
    }
    public function nuevoadmin($id){
        /* Convertir un usuario en nuevo admin */
        User::where('codUsuario',$id)->update(['administrador'=>"si"]);
        return redirect(route('dashboard'));
    }
    public function borrarusuario($id){
        /* Borrar un usuario */
        User::where('codUsuario',$id)->delete();
        return redirect(route('dashboard'));
    }
    public function logout(Request $request){
        /* Cerrar sesion de mi administrador */
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('welcome'));
    }

}
