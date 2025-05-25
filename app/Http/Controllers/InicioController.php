<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Leccion;
use App\Models\Racha;
use App\Models\ProgresoUsuario;

class InicioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $lecciones = Leccion::all();
        $totalLecciones = $lecciones->count();

        $progreso = 0;
        $racha = 0;
        $puedeDescargarCertificado = false;

        if ($usuario) {
            // Obtener progreso del usuario
            $progresoUsuario = ProgresoUsuario::where('id_usuario', $usuario->id)->first();

            if ($progresoUsuario) {
                $ejerciciosCompletados = $progresoUsuario->ejercicios_completados;

                if ($ejerciciosCompletados == 100) {
                    $progreso = 100;
                    $puedeDescargarCertificado = true;
                } else {
                    // Opcional: calcular progreso si quieres mostrar progreso parcial
                    $progreso = $ejerciciosCompletados;
                }
            }

            // Obtener racha
            if ($usuario->racha) {
                $racha = $usuario->racha->dias_consecutivos;
            }
        }

        return view('inicio', compact('lecciones', 'progreso', 'racha', 'puedeDescargarCertificado'));
    }
}
