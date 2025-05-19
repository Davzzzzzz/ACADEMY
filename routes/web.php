<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\LeccionController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\RachaController;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ProgresoUsuarioController;
use App\Http\Controllers\PublicacionController;

// Login / Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registro
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Inicio (principal)
Route::get('/inicio', [InicioController::class, 'index'])->name('inicio')->middleware('auth');

// Publicaciones
Route::post('/publicaciones', [PublicacionController::class, 'store'])->name('publicaciones.store');
Route::get('/publicaciones/{id}/editar', [PublicacionController::class, 'edit'])->name('publicaciones.edit');
Route::put('/publicaciones/{id}', [PublicacionController::class, 'update'])->name('publicaciones.update');

// Foros (solo usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::resource('foros', ForoController::class);
    Route::get('/lecciones/{id}/ejercicios', [EjercicioController::class, 'mostrarEjercicios'])->name('lecciones.ejercicios');
});

// Panel de administración (solo admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('usuarios', App\Http\Controllers\Admin\UsuarioAdminController::class);
    Route::resource('roles', App\Http\Controllers\Admin\RolAdminController::class);
    Route::resource('lecciones', App\Http\Controllers\Admin\LeccionAdminController::class);
    Route::resource('niveles', App\Http\Controllers\Admin\NivelAdminController::class);
    Route::resource('rachas', App\Http\Controllers\Admin\RachaAdminController::class);
    Route::resource('comentarios', App\Http\Controllers\Admin\ComentarioAdminController::class);
    Route::resource('reportes', App\Http\Controllers\Admin\ReporteAdminController::class);
    Route::resource('progresousuario', App\Http\Controllers\Admin\ProgresoUsuarioAdminController::class);
    Route::resource('ejercicios', App\Http\Controllers\Admin\EjercicioAdminController::class);
    Route::resource('foros', App\Http\Controllers\Admin\ForoAdminController::class);
});
