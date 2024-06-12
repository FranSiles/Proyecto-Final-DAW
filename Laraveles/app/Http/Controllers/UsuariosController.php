<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
   
    public function index()
    {
        $usuarios = User::all();
        return response()->json($usuarios);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $rules = [
            'codUsuario' => 'required',
            'nomUsuario' => 'required',
            'correo' => 'required|email|unique:usuarios',
            'contraseña' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Ejemplo de validación para una imagen
        ];

        $request->validate($rules);
    
        // Crear un nuevo objeto Usuarios con los datos del formulario
        $usuario = new User([
            'codUsuario' => $request->input('codUsuario'),
            'nomUsuario' => $request->input('nomUsuario'),
            'correo' => $request->input('correo'),
            'contraseña' => bcrypt($request->input('contraseña')), // Hashear la contraseña antes de guardarla
        ]);
    
        // Procesar la imagen si se ha cargado
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $usuario->foto = $imageName;
        }
    
        // Guardar el usuario en la base de datos
        $usuario->save();
    
        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Usuario creado correctamente'], 201);
    }
    public function show($codUsuario)
    {
        $usuario=User::find($codUsuario);
        return response()->json($usuario);
    }  
    public function edit(User $usuarios)
    {
        //// Retorna la vista para editar un usuario (si es una aplicación web)
    }
    public function update(Request $request, $codUsuario){
    $email=$request->input('email');
    $nomUsuario=$request->input('nomUsuario');
    $password=$request->input('password');
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        'nomUsuario'=>'required|string',
    ]);
    $nombre=User::where('nomUsuario',$nomUsuario)->first();
    if(!$nombre){
        User::where('codUsuario' , $codUsuario)->update(['email'=>$email,
                                                        'nomUsuario'=>$nomUsuario,
                                                        'password'=>Hash::make($password)]);
        // Retornar una respuesta de éxito
        $usuarioeliminotoken = $request->user();
        $usuarioeliminotoken->currentAccessToken()->delete();
        return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
    }else{
        return response()->json(["status" => "error","message" => "El nombre del usuario ya existe"], 422);
    }
}
    public function destroy($id,Request $request){
        $usuario = User::where('codUsuario', $id)->first();
        $usuarioeliminotoken = $request->user();
        $usuarioeliminotoken->currentAccessToken()->delete();
        $usuario->delete();
        /* return response()->json(['message' => 'Usuario eliminado correctamente'], 200); */
    }
    public function registro(Request $request){
        $email=$request->input('email');
        $password=$request->input('password');
        $nomUsuario=$request->input('nombre');
        $foto=$request->file('foto');
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'nombre'=>'required|string',
            'foto'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $usuario=User::where('email',$email)->first();
        $nombre=User::where('nomUsuario',$nomUsuario)->first();
        if(!$usuario && !$nombre){
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
        $request->validate([
            'foto'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $foto=$request->file('foto');
        $ruta=$foto->store('public');
        $ruta = 'storage/' . str_replace('public/', '', $ruta);
        User::where('codUsuario',Auth::user()->codUsuario)->update(['foto'=>$ruta]);
        return response()->json(['message' => 'Foto de usuario actualizada correctamente'], 200);
    }
    public function obtenerComentariosYValoraciones($codUsuario)
    {
        // Ordenar por fecha o cualquier otro criterio si es necesario
        $usuario = User::find($codUsuario);

        // Obtén los comentarios y valoraciones del usuario, o colecciones vacías si el usuario no existe
        $comentarios =$usuario->comentarios;
        $valoraciones =$usuario->valoraciones;
        $resultados = [];

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
        /* dd($resultados); */
        return response()->json($resultados,200);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
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
        $usuarios=User::all();
        return view('dashboard',['usuarios'=>$usuarios]);
    }
    public function nuevoadmin($id){
        User::where('codUsuario',$id)->update(['administrador'=>"si"]);
        return redirect(route('dashboard'));
    }
    public function borrarusuario($id){
        User::where('codUsuario',$id)->delete();
        return redirect(route('dashboard'));
    }
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('welcome'));
    }

}
