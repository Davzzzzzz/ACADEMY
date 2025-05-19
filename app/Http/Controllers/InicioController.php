<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Leccion;
use App\Models\Racha;

class InicioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        // Obtener todas las lecciones (ajústalo si tienes paginación o filtros)
        $lecciones = Leccion::all();

        // Simulación del progreso, puedes reemplazar con tu lógica real
        $progreso = 70;

        // Obtener la racha del usuario actual, si existe
        $racha = 0;
        if ($usuario && $usuario->racha) {
            $racha = $usuario->racha->dias_consecutivos;
        }

        return view('inicio', compact('lecciones', 'progreso', 'racha'));
    }
}
