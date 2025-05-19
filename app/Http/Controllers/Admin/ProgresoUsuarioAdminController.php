<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgresoUsuario;
use App\Models\Usuario;
use App\Models\Nivel;
use App\Models\Leccion;

class ProgresoUsuarioAdminController extends Controller
{
    // Listar todos los progresos
    public function index()
    {
        $progresos = ProgresoUsuario::with(['usuario', 'nivel', 'leccion'])->get();
        return view('admin.progreso_usuarios.index', compact('progresos'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $usuarios = Usuario::all();
        $niveles = Nivel::all();
        $lecciones = Leccion::all();
        return view('admin.progreso_usuarios.create', compact('usuarios', 'niveles', 'lecciones'));
    }

    // Guardar nuevo progreso
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id',
            'id_nivel' => 'required|exists:niveles,id_nivel',
            'id_leccion_actual' => 'nullable|exists:lecciones,id_leccion',
            'ejercicios_completados' => 'required|integer|min:0',
        ]);

        ProgresoUsuario::create($request->all());

        return redirect()->route('admin.progresousuario.index')->with('success', 'Progreso creado correctamente.');
    }

    // Mostrar un progreso individual
    public function show($id)
    {
        $progreso = ProgresoUsuario::with(['usuario', 'nivel', 'leccion'])->findOrFail($id);
        return view('admin.progreso_usuarios.show', compact('progreso'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $progreso = ProgresoUsuario::findOrFail($id);
        $usuarios = Usuario::all();
        $niveles = Nivel::all();
        $lecciones = Leccion::all();
        return view('admin.progreso_usuarios.edit', compact('progreso', 'usuarios', 'niveles', 'lecciones'));
    }

    // Actualizar progreso
    public function update(Request $request, $id)
    {
        $progreso = ProgresoUsuario::findOrFail($id);

        $request->validate([
            'id_usuario' => 'required|exists:usuario,id',
            'id_nivel' => 'required|exists:niveles,id_nivel',
            'id_leccion_actual' => 'nullable|exists:lecciones,id_leccion',
            'ejercicios_completados' => 'required|integer|min:0',
        ]);

        $progreso->update($request->all());

        return redirect()->route('admin.progresousuario.index')->with('success', 'Progreso actualizado correctamente.');
    }

    // Eliminar progreso (soft delete)
    public function destroy($id)
    {
        $progreso = ProgresoUsuario::findOrFail($id);
        $progreso->delete();

        return redirect()->route('admin.progresousuario.index')->with('success', 'Progreso eliminado correctamente.');
    }
}
