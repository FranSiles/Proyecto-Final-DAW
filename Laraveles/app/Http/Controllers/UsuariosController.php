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
    public function update(Request $request, User $usuarios)
{
    // Validar los datos del formulario
    $rules = [
        'codUsuario' => 'required',
        'nomUsuario' => 'required',
        'correo' => 'required|email|unique:usuarios,correo,'.$usuarios->id,
        'contraseña' => 'required',
        'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Ejemplo de validación para una imagen
    ];

    $request->validate($rules);

    // Actualizar los datos del usuario con los datos del formulario
    $usuarios->update([
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
        $usuarios->foto = $imageName;
        $usuarios->save();
    }

    // Retornar una respuesta de éxito
    return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
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
        if($foto){
            $imagen = $foto;
            $ruta=$imagen->store('public');
            $ruta = 'storage/' . str_replace('public/', '', $ruta);
            User::create([
                'nomUsuario' => $nomUsuario,
                'email' => $email,
                'password' => Hash::make($password),
                'foto' => $ruta 
            ]);
        }else{
            User::create([
                'nomUsuario' => $nomUsuario,
                'email' => $email,
                'password' => Hash::make($password)]);
        }
        
    }
}
