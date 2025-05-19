<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Foro;
use App\Models\Comentario;
use App\Models\Reporte;
use App\Models\ProgresoUsuario;
use App\Models\Racha;
use App\Models\Ejercicio;
use App\Models\Leccion;
use App\Models\Nivel;
use App\Models\Rol;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Cargar todos los datos que quieras mostrar en dashboard
        $usuarios = Usuario::all();
        $foros = Foro::all();
        $comentarios = Comentario::all();
        $reportes = Reporte::all();
        $progresos = ProgresoUsuario::all();
        $rachas = Racha::all();
        $ejercicios = Ejercicio::all();
        $lecciones = Leccion::all();
        $niveles = Nivel::all();
        $roles = Rol::all();

        return view('admin.dashboard', compact(
            'usuarios',
            'foros',
            'comentarios',
            'reportes',
            'progresos',
            'rachas',
            'ejercicios',
            'lecciones',
            'niveles',
            'roles'
        ));
    }
}
