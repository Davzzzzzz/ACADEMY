<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Foro;

class ForoAdminController extends Controller
{
    // Mostrar todos los foros
    public function index()
    {
        $foros = Foro::all();
        return view('admin.foros.index', compact('foros'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('admin.foros.create');
    }

    // Guardar un nuevo foro
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        Foro::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.foros.index')->with('success', 'Foro creado correctamente.');
    }

    // Mostrar un foro específico
    public function show($id)
    {
        $foro = Foro::findOrFail($id);
        return view('admin.foros.show', compact('foro'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $foro = Foro::findOrFail($id);
        return view('admin.foros.edit', compact('foro'));
    }

    // Actualizar un foro existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        $foro = Foro::findOrFail($id);
        $foro->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.foros.index')->with('success', 'Foro actualizado correctamente.');
    }

    // Eliminar un foro
    public function destroy($id)
    {
        $foro = Foro::findOrFail($id);
        $foro->delete();

        return redirect()->route('admin.foros.index')->with('success', 'Foro eliminado correctamente.');
    }
}
