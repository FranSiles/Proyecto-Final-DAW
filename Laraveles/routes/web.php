<?php

use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\JuegosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ValoracionesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/','welcome')->name('welcome');//vista de inicio
Route::post('/iniciar-sesion',[UsuariosController::class,"login"])->name('iniciar-sesion');//iniciar sesion con una funcion en mi controlador
Route::get('/listausuarios',[UsuariosController::class,'mostrarusuarios'])->middleware('auth','admin')->name('dashboard');//lista de usuarios de mi aplicacion
Route::get('/listajuegos',[JuegosController::class,'mostrarjuegos'])->middleware('auth','admin')->name('listajuegos');//lista de juegos de mi aplicaion 
Route::get('/listacomentarios',[ComentariosController::class,'mostrarcomentarios'])->middleware('auth','admin')->name('listacomentarios');//lista de comentarios de mi aplicaion
Route::get('/listavaloraciones',[ValoracionesController::class,'mostrarvaloraciones'])->middleware('auth','admin')->name('listavaloraciones');//lista de valoraciones de mi aplicacion
Route::post('/nuevoadmin/{id}',[UsuariosController::class,"nuevoAdmin"])->middleware('auth','admin')->name('nuevoAdmin');//convertir en admin a un usuario
Route::post('/borrarusuario/{id}',[UsuariosController::class,"borrarusuario"])->middleware('auth','admin')->name('borrarusuario');//borrar a un usuario
Route::post('/borrarjuego/{id}',[JuegosController::class,"borrarjuego"])->middleware('auth','admin')->name('borrarjuego');//borrar un juego
Route::post('/borrarcomentario/{id}',[ComentariosController::class,"borrarcomentarios"])->middleware('auth','admin')->name('borrarcomentario');//borrar un comentario
Route::post('/borrarvaloracion/{id}',[ComentariosController::class,"borrarvaloraciones"])->middleware('auth','admin')->name('borrarvaloracion');//borrar una valoracion
Route::get('/logout',[UsuariosController::class,"logout"])->middleware('auth','admin')->name('logout');//cerrar sesion

require __DIR__.'/auth.php';
