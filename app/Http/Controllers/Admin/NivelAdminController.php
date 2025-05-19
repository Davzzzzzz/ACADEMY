<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nivel;

class NivelAdminController extends Controller
{
    // Listar todos los niveles
    public function index()
    {
        $niveles = Nivel::all();
        return view('admin.niveles.index', compact('niveles'));
    }

    // Mostrar formulario para crear un nuevo nivel
    public function create()
    {
        return view('admin.niveles.create');
    }

    // Guardar nuevo nivel
    public function store(Request $request)
    {
        $request->validate([
            'nombre_nivel' => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
        ]);

        Nivel::create($request->all());

        return redirect()->route('admin.niveles.index')->with('success', 'Nivel creado correctamente.');
    }

    // Mostrar un nivel específico
    public function show($id)
    {
        $nivel = Nivel::findOrFail($id);
        return view('admin.niveles.show', compact('nivel'));
    }

    // Mostrar formulario para editar un nivel
    public function edit($id)
    {
        $nivel = Nivel::findOrFail($id);
        return view('admin.niveles.edit', compact('nivel'));
    }

    // Actualizar un nivel
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_nivel' => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
        ]);

        $nivel = Nivel::findOrFail($id);
        $nivel->update($request->all());

        return redirect()->route('admin.niveles.index')->with('success', 'Nivel actualizado correctamente.');
    }

    // Eliminar un nivel
    public function destroy($id)
    {
        $nivel = Nivel::findOrFail($id);
        $nivel->delete();

        return redirect()->route('admin.niveles.index')->with('success', 'Nivel eliminado correctamente.');
    }
}
