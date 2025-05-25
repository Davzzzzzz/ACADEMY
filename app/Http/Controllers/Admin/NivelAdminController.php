<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nivel;

class NivelAdminController extends Controller
{
    // Mostrar lista de niveles
    public function index()
    {
        $niveles = Nivel::paginate(10);
        return view('admin.niveles.index', compact('niveles'));
    }

    // Formulario para crear nivel
    public function create()
    {
        return view('admin.niveles.create');
    }

    // Guardar nivel nuevo
    public function store(Request $request)
    {
        $request->validate([
            'nombre_nivel' => 'required|string|max:255',
            'descripcion'  => 'nullable|string|max:1000',
        ]);

        Nivel::create([
            'nombre_nivel' => $request->nombre_nivel,
            'descripcion'  => $request->descripcion,
        ]);

        return redirect()->route('admin.niveles.index')->with('success', 'Nivel creado correctamente.');
    }

    // Mostrar un nivel específico
    public function show($id)
    {
        $nivel = Nivel::findOrFail($id);
        return view('admin.niveles.show', compact('nivel'));
    }

    // Formulario para editar nivel
    public function edit($id)
    {
        $nivel = Nivel::findOrFail($id);
        return view('admin.niveles.edit', compact('nivel'));
    }

    // Actualizar nivel
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_nivel' => 'required|string|max:255',
            'descripcion'  => 'nullable|string|max:1000',
        ]);

        $nivel = Nivel::findOrFail($id);
        $nivel->update([
            'nombre_nivel' => $request->nombre_nivel,
            'descripcion'  => $request->descripcion,
        ]);

        return redirect()->route('admin.niveles.index')->with('success', 'Nivel actualizado correctamente.');
    }

    // Eliminar nivel
    public function destroy($id)
    {
        $nivel = Nivel::findOrFail($id);
        $nivel->delete();

        return redirect()->route('admin.niveles.index')->with('success', 'Nivel eliminado correctamente.');
    }
}
