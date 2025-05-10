<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PublicacionController;

// Ruta principal protegida
Route::get('/inicio', function () {
    $lecciones = \App\Models\Leccion::all();
    $progreso = 75;
    return view('inicio', compact('lecciones', 'progreso'));
})->name('inicio')->middleware('auth');

// Login / Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registro
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Publicaciones
Route::post('/publicaciones', [PublicacionController::class, 'store'])->name('publicaciones.store');
Route::get('/publicaciones/{id}/editar', [PublicacionController::class, 'edit'])->name('publicaciones.edit');
Route::put('/publicaciones/{id}', [PublicacionController::class, 'update'])->name('publicaciones.update');

// Foros (todas las rutas protegidas con 'auth')
Route::middleware('auth')->group(function () {
    Route::resource('foros', ForoController::class);
});

//Ejercicios
Route::get('/lecciones/{id}/ejercicios', [App\Http\Controllers\EjercicioController::class, 'mostrarEjercicios'])->name('lecciones.ejercicios');
