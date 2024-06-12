<?php

use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\JuegosController;
use App\Http\Controllers\ProfileController;
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

Route::view('/','welcome')->name('welcome');
Route::post('/iniciar-sesion',[UsuariosController::class,"login"])->name('iniciar-sesion');
/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */
/* Route::get('/dashboard')->name('dashboard'); */
/* Route::get('/admin',[UsuarioController::class,'mostrarusuarios'])->middleware('auth','admin')->name('admin'); */
Route::get('/listausuarios',[UsuariosController::class,'mostrarusuarios'])->middleware('auth','admin')->name('dashboard');
Route::get('/listajuegos',[JuegosController::class,'mostrarjuegos'])->middleware('auth','admin')->name('listajuegos');
Route::get('/listacomentarios',[ComentariosController::class,'mostrarcomentarios'])->middleware('auth','admin')->name('listacomentarios');
Route::get('/listavaloraciones',[ValoracionesController::class,'mostrarvaloraciones'])->middleware('auth','admin')->name('listavaloraciones');
Route::post('/nuevoadmin/{id}',[UsuariosController::class,"nuevoAdmin"])->middleware('auth','admin')->name('nuevoAdmin');
Route::post('/borrarusuario/{id}',[UsuariosController::class,"borrarusuario"])->middleware('auth','admin')->name('borrarusuario');
Route::post('/borrarjuego/{id}',[JuegosController::class,"borrarjuego"])->middleware('auth','admin')->name('borrarjuego');
Route::post('/borrarcomentario/{id}',[ComentariosController::class,"borrarcomentarios"])->middleware('auth','admin')->name('borrarcomentario');
Route::post('/borrarvaloracion/{id}',[ComentariosController::class,"borrarvaloraciones"])->middleware('auth','admin')->name('borrarvaloracion');
Route::get('/logout',[UsuariosController::class,"logout"])->middleware('auth','admin')->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
