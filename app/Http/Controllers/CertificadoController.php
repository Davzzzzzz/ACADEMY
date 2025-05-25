<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Leccion;
use App\Models\ProgresoUsuario;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoController extends Controller
{
    public function generar()
{
    $usuario = auth()->user();

    $progreso = ProgresoUsuario::where('id_usuario', $usuario->id)->first();

    if ($progreso && $progreso->ejercicios_completados == 100) {
        $pdf = Pdf::loadView('certificados.certificado', compact('usuario'));
        return $pdf->download('certificado_academy_hands.pdf');
    } else {
        return redirect()->back()->with('error', 'Aún no has completado todas las lecciones.');
    }
}

}

