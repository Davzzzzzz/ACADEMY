<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ReporteAdminController extends Controller
{
    // Mostrar todos los reportes
    public function index()
    {
        $reportes = Reporte::with('usuario')->paginate(10);
        return view('admin.reportes.index', compact('reportes'));
    }

    // Mostrar formulario para crear un nuevo reporte
    public function create()
    {
        $usuarios = Usuario::all();
        return view('admin.reportes.create', compact('usuarios'));
    }

    // Guardar un nuevo reporte
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id', // Corregido aquí
            'descripcion' => 'required|string',
            'fecha_reporte' => 'required|date'
        ]);

        Reporte::create([
            'id_usuario' => $request->id_usuario,
            'descripcion' => $request->descripcion,
            'fecha_reporte' => $request->fecha_reporte,
        ]);

        return redirect()->route('admin.reportes.index')->with('success', 'Reporte creado correctamente.');
    }

    // Mostrar un reporte específico
    public function show($id)
    {
        $reporte = Reporte::with('usuario')->findOrFail($id);
        return view('admin.reportes.show', compact('reporte'));
    }

    // Mostrar formulario para editar un reporte
    public function edit($id)
    {
        $reporte = Reporte::findOrFail($id);
        $usuarios = Usuario::all();
        return view('admin.reportes.edit', compact('reporte', 'usuarios'));
    }

    // Actualizar un reporte existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id', // Corregido aquí
            'descripcion' => 'required|string',
            'fecha_reporte' => 'required|date'
        ]);

        $reporte = Reporte::findOrFail($id);
        $reporte->update([
            'id_usuario' => $request->id_usuario,
            'descripcion' => $request->descripcion,
            'fecha_reporte' => $request->fecha_reporte,
        ]);

        return redirect()->route('admin.reportes.index')->with('success', 'Reporte actualizado correctamente.');
    }

    // Eliminar un reporte
    public function destroy($id)
    {
        $reporte = Reporte::findOrFail($id);
        $reporte->delete();

        return redirect()->route('admin.reportes.index')->with('success', 'Reporte eliminado correctamente.');
    }
}
