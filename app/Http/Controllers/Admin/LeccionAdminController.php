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
        $lecciones = Leccion::paginate(10);
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
        ], [
            'id_nivel.required' => 'El campo nivel es obligatorio.',
            'id_nivel.exists' => 'El nivel seleccionado no es válido.',
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'contenido.required' => 'El contenido no puede estar vacío.',
        ]);

        Leccion::create($request->only(['id_nivel', 'titulo', 'contenido']));

        return redirect()->route('admin.lecciones.index')
                         ->with('success', 'Lección creada correctamente.');
    }

    // Mostrar detalles de una lección
    public function show($id)
    {
        $leccion = Leccion::with('nivel')->findOrFail($id);
        return view('admin.lecciones.show', compact('leccion'));
    }

    // Mostrar formulario para editar una lección
    public function edit($id)
    {
        $leccion = Leccion::findOrFail($id);
        $niveles = Nivel::all();
        return view('admin.lecciones.edit', compact('leccion', 'niveles'));
    }

    // Actualizar una lección existente
    public function update(Request $request, $id)
    {
        $leccion = Leccion::findOrFail($id);

        $request->validate([
            'id_nivel' => 'required|exists:niveles,id_nivel',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ], [
            'id_nivel.required' => 'El campo nivel es obligatorio.',
            'id_nivel.exists' => 'El nivel seleccionado no es válido.',
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'contenido.required' => 'El contenido no puede estar vacío.',
        ]);

        $leccion->update($request->only(['id_nivel', 'titulo', 'contenido']));

        return redirect()->route('admin.lecciones.index')
                         ->with('success', 'Lección actualizada correctamente.');
    }

    // Eliminar una lección
    public function destroy($id)
    {
        $leccion = Leccion::findOrFail($id);
        $leccion->delete();

        return redirect()->route('admin.lecciones.index')
                         ->with('success', 'Lección eliminada correctamente.');
    }
}
