<?php

use App\Http\Controllers\ApiAuthenticationController;
use App\Http\Controllers\JuegosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\ValoracionesController;
use App\Models\Comentarios;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* FUncionalidades de mi usuario */
Route::delete('usuarios/{id}',[UsuariosController::class,'destroy'])->middleware("auth:sanctum");//eliminar usuario
Route::get('usuarios/{id}',[UsuariosController::class,'show'])->middleware("auth:sanctum");//mostar usuario
Route::put('usuarios/{id}',[UsuariosController::class,'update'])->middleware("auth:sanctum");//actualziar un usuario
Route::post('/usuarios', [UsuariosController::class,'cambiarfoto'])->middleware("auth:sanctum");//cambio de foto dle usuario
Route::post('login', [ApiAuthenticationController::class, 'login']);//inicio de sesion de usuario
Route::post('logout', [ApiAuthenticationController::class, "logout"])->middleware("auth:sanctum");//cerrar sesion
Route::post('registro', [UsuariosController::class, 'registro']);//registro de un usuario
Route::get('/comentariosyvaloracines/{id}',[UsuariosController::class,'obtenerComentariosYValoraciones'])->middleware("auth:sanctum");//obtencion de comentarios y valoraciones
/* FUncionalidades de mi  juegos*/
Route::get('/juegos', [JuegosController::class, 'index']); // Obtener todos los juegos
Route::get('/juegosaleatorios/{id}',[JuegosController::class,'juegosaleatorios']); //obtencion de un array de juegos aleatorios
Route::get('/juegos/{id}', [JuegosController::class, 'show']); // Obtener un juego especifico
Route::post('/juegos', [JuegosController::class, 'store'])->middleware("auth:sanctum");//registro de un juego
Route::delete('/juegos/{id}',[JuegosController::class, 'destroy'])->middleware("auth:sanctum");//eliminar un juego de un usuario
Route::get('juegosusuario/{id}', [JuegosController::class,'juegosusuario'])->middleware("auth:sanctum");//mostrar los juegos del usuario
/* Funcionalidades de mi  comentarios */
Route::post('/subircomentarios', [ComentariosController::class, 'store']);//subir comentarios 
Route::get('/comentarios/{id}', [ComentariosController::class, 'getComentarios']);//obtenercomentairos de un juego
/* Funcionalidades de mi valoraciones */
Route::post('/subirvaloraciones', [ValoracionesController::class, 'store']);//subir valoracion
Route::get('/valoraciones/{id}', [ValoracionesController::class, 'getValoraciones']);//obtener valoraciones 
Route::get('/valoracionesgrafica', [ValoracionesController::class, 'obtenerValoracionesJuego']);//obtener valoraciones para la grafica
Route::get('/mediaValoracionesJuego/{codJuego}', [ValoracionesController::class, 'mediaValoracionesJuego']);//obtener media de valoraicones de un juego
