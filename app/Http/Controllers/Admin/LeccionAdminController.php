<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leccion;
use App\Models\Nivel;

class LeccionAdminController extends Controller
{
    // Listar todas las lecciones
    public function index()
    {
        $lecciones = Leccion::with('nivel')->get();
        return view('admin.lecciones.index', compact('lecciones'));
    }

    // Mostrar formulario para crear nueva lección
    public function create()
    {
        $niveles = Nivel::all();
        return view('admin.lecciones.create', compact('niveles'));
    }

    // Guardar nueva lección
    public function store(Request $request)
    {
        $request->validate([
            'id_nivel' => 'required|exists:niveles,id_nivel',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ]);

        Leccion::create([
            'id_nivel' => $request->id_nivel,
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        return redirect()->route('admin.lecciones.index')->with('success', 'Lección creada correctamente.');
    }

    // Mostrar una lección
    public function show($id)
    {
        $leccion = Leccion::with('nivel')->findOrFail($id);
        return view('admin.lecciones.show', compact('leccion'));
    }

    // Mostrar formulario para editar
    public function edit($id)
    {
        $leccion = Leccion::findOrFail($id);
        $niveles = Nivel::all();
        return view('admin.lecciones.edit', compact('leccion', 'niveles'));
    }

    // Actualizar lección
    public function update(Request $request, $id)
    {
        $leccion = Leccion::findOrFail($id);

        $request->validate([
            'id_nivel' => 'required|exists:niveles,id_nivel',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ]);

        $leccion->update([
            'id_nivel' => $request->id_nivel,
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        return redirect()->route('admin.lecciones.index')->with('success', 'Lección actualizada correctamente.');
    }

    // Eliminar lección
    public function destroy($id)
    {
        $leccion = Leccion::findOrFail($id);
        $leccion->delete();

        return redirect()->route('admin.lecciones.index')->with('success', 'Lección eliminada correctamente.');
    }
}
