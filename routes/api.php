<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\LeccionController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProgresoUsuarioController;
use App\Http\Controllers\RachaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\TipoPreguntaController;
use App\Http\Controllers\UsuarioController;

// Ruta para obtener información del usuario autenticado (no modificar)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Comentario Routes
Route::prefix('comentarios')->group(function () {
    Route::get('/', [ComentarioController::class, 'index']);
    Route::get('/{id}', [ComentarioController::class, 'show']);
    Route::post('/', [ComentarioController::class, 'store']);
    Route::put('/{id}', [ComentarioController::class, 'update']);
    Route::delete('/{id}', [ComentarioController::class, 'destroy']);
});

// Ejercicio Routes
Route::prefix('ejercicios')->group(function () {
    Route::get('/', [EjercicioController::class, 'index']);
    Route::get('/{id}', [EjercicioController::class, 'show']);
    Route::post('/', [EjercicioController::class, 'store']);
    Route::put('/{id}', [EjercicioController::class, 'update']);
    Route::delete('/{id}', [EjercicioController::class, 'destroy']);
});

// Foro Routes
Route::prefix('foros')->group(function () {
    Route::get('/', [ForoController::class, 'index']);
    Route::get('/{id}', [ForoController::class, 'show']);
    Route::post('/', [ForoController::class, 'store']);
    Route::put('/{id}', [ForoController::class, 'update']);
    Route::delete('/{id}', [ForoController::class, 'destroy']);
});

// Leccion Routes
Route::prefix('lecciones')->group(function () {
    Route::get('/', [LeccionController::class, 'index']);
    Route::get('/{id}', [LeccionController::class, 'show']);
    Route::post('/', [LeccionController::class, 'store']);
    Route::put('/{id}', [LeccionController::class, 'update']);
    Route::delete('/{id}', [LeccionController::class, 'destroy']);
});

// Nivel Routes
Route::prefix('niveles')->group(function () {
    Route::get('/', [NivelController::class, 'index']);
    Route::get('/{id}', [NivelController::class, 'show']);
    Route::post('/', [NivelController::class, 'store']);
    Route::put('/{id}', [NivelController::class, 'update']);
    Route::delete('/{id}', [NivelController::class, 'destroy']);
});

// Permiso Routes
Route::prefix('permisos')->group(function () {
    Route::get('/', [PermisoController::class, 'index']);
    Route::get('/{id}', [PermisoController::class, 'show']);
    Route::post('/', [PermisoController::class, 'store']);
    Route::put('/{id}', [PermisoController::class, 'update']);
    Route::delete('/{id}', [PermisoController::class, 'destroy']);
});

// ProgresoUsuario Routes
Route::prefix('progreso-usuarios')->group(function () {
    Route::get('/', [ProgresoUsuarioController::class, 'index']);
    Route::get('/{id}', [ProgresoUsuarioController::class, 'show']);
    Route::post('/', [ProgresoUsuarioController::class, 'store']);
    Route::put('/{id}', [ProgresoUsuarioController::class, 'update']);
    Route::delete('/{id}', [ProgresoUsuarioController::class, 'destroy']);
});

// Racha Routes
Route::prefix('rachas')->group(function () {
    Route::get('/', [RachaController::class, 'index']);
    Route::get('/{id}', [RachaController::class, 'show']);
    Route::post('/', [RachaController::class, 'store']);
    Route::put('/{id}', [RachaController::class, 'update']);
    Route::delete('/{id}', [RachaController::class, 'destroy']);
});

// Reporte Routes
Route::prefix('reportes')->group(function () {
    Route::get('/', [ReporteController::class, 'index']);
    Route::get('/{id}', [ReporteController::class, 'show']);
    Route::post('/', [ReporteController::class, 'store']);
    Route::put('/{id}', [ReporteController::class, 'update']);
    Route::delete('/{id}', [ReporteController::class, 'destroy']);
});

// Rol Routes
Route::prefix('roles')->group(function () {
    Route::get('/', [RolController::class, 'index']);
    Route::get('/{id}', [RolController::class, 'show']);
    Route::post('/', [RolController::class, 'store']);
    Route::put('/{id}', [RolController::class, 'update']);
    Route::delete('/{id}', [RolController::class, 'destroy']);
});

// TipoPregunta Routes
Route::prefix('tipo_pregunta')->group(function () {
    Route::get('/', [TipoPreguntaController::class, 'index']);
    Route::get('/{id}', [TipoPreguntaController::class, 'show']);
    Route::post('/', [TipoPreguntaController::class, 'store']);
    Route::put('/{id}', [TipoPreguntaController::class, 'update']);
    Route::delete('/{id}', [TipoPreguntaController::class, 'destroy']);
});

// Usuario Routes
Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::get('/{id}', [UsuarioController::class, 'show']);
    Route::post('/', [UsuarioController::class, 'store']);
    Route::put('/{id}', [UsuarioController::class, 'update']);
    Route::delete('/{id}', [UsuarioController::class, 'destroy']);
});
