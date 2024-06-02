<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiAuthenticationController extends Controller
{
    
    public function login(Request $request){
        try {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
        }
        $email=$request->input('email');
        $password=$request->input('password');
        if (Auth::attempt(['email' => $email, 'password' => $password])){
            /*dd(Auth::user());*/
            $token = Auth::user()->createToken($request->fingerprint())->plainTextToken;
            return response()->json(["status"  => "success",
                            "message" => "Login realizado con éxito",
                            "data"    => [ "token" => $token,
                                           "nomUsuario"=>Auth::user()->nomUsuario,
                                           "foto"=>Auth::user()->foto,
                                           "codUsuario"=>Auth::user()->codUsuario],
                            ]);
        }else{
            return response()->json(["status" => "error","message" => "Credenciales incorrectas"], 422);
        }
    }
    public function logout(Request $request)
{
    $usuario = $request->user();
    $usuario->currentAccessToken()->delete();

    return response()->json(['message' => 'Logout exitoso']);
}


}
