<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
   
    public function index()
    {
        $usuarios = Usuarios::all();
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
        $usuario = new Usuarios([
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
    public function show(Usuarios $usuarios)
    {
        return response()->json($usuarios);
    }  
    public function edit(Usuarios $usuarios)
    {
        //// Retorna la vista para editar un usuario (si es una aplicación web)
    }
    public function update(Request $request, Usuarios $usuarios)
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
    public function destroy(Usuarios $usuarios)
    {
        // Eliminar el usuario de la base de datos
        $usuarios->delete();
    
        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}
