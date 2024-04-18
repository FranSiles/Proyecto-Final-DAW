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
        //
    }  
    public function show(Usuarios $usuarios)
    {
        //
    }  
    public function edit(Usuarios $usuarios)
    {
        //
    }
    public function update(Request $request, Usuarios $usuarios)
    {
        //
    } 
    public function destroy(Usuarios $usuarios)
    {
        //
    }
}
