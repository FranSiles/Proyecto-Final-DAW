<?php

use App\Http\Controllers\ApiAuthenticationController;
use App\Http\Controllers\JuegosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\ValoracionesController;
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

/* Route::resource('Usuarios',UsuariosController::class); */
/* Route::resource('juegos',JuegosController::class); */
Route::get('users',[UsuariosController::class,'index']);
Route::delete('usuarios/{id}',[UsuariosController::class,'destroy'])->middleware("auth:sanctum");
Route::get('usuarios/{id}',[UsuariosController::class,'show'])->middleware("auth:sanctum");
Route::post('login', [ApiAuthenticationController::class, 'login']);
Route::post('registro', [UsuariosController::class, 'registro']);
/* Route::get('juegos',[JuegosController::class,'index']); */
Route::get('/juegos', [JuegosController::class, 'index']); // Obtener todos los juegos
Route::get('/juegos/{id}', [JuegosController::class, 'show']); // Obtener un juego especifico
Route::post('/juegos', [JuegosController::class, 'store'])->middleware("auth:sanctum");
/* Route::post('juego',[JuegosController::class,'obtenerJuego']); */
/* Route::post('registrojuego',[JuegosController::class,'anadirJuego'])->middleware("auth:sanctum"); */
Route::post('logout', [ApiAuthenticationController::class, "logout"])->middleware("auth:sanctum");
Route::post('/subircomentarios', [ComentariosController::class, 'store']);
Route::get('/comentarios/{id}', [ComentariosController::class, 'getComentarios']);
Route::post('/subirvaloraciones', [ValoracionesController::class, 'store']);
Route::get('/valoraciones/{id}', [ValoracionesController::class, 'getValoraciones']);
Route::get('/valoracionesgrafica', [ValoracionesController::class, 'obtenerValoracionesJuego']);
