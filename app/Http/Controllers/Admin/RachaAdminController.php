<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Racha;
use App\Models\Usuario;
use Illuminate\Http\Request;

class RachaAdminController extends Controller
{
    // Mostrar listado de rachas
    public function index()
    {
        $rachas = Racha::with('usuario')->paginate(5);
        return view('admin.rachas.index', compact('rachas'));
    }

    // Mostrar formulario para crear una nueva racha
    public function create()
    {
        $usuarios = Usuario::all();
        return view('admin.rachas.create', compact('usuarios'));
    }

    // Guardar nueva racha en BD
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id', // corregido
            'dias_consecutivos' => 'required|integer|min:0',
            'ultima_fecha' => 'nullable|date',
        ]);

        Racha::create($request->all());

        return redirect()->route('admin.rachas.index')->with('success', 'Racha creada correctamente.');
    }

    // Mostrar una racha específica
    public function show($id)
    {
        $racha = Racha::with('usuario')->findOrFail($id);
        return view('admin.rachas.show', compact('racha'));
    }

    // Mostrar formulario para editar una racha
    public function edit($id)
    {
        $racha = Racha::findOrFail($id);
        $usuarios = Usuario::all();
        return view('admin.rachas.edit', compact('racha', 'usuarios'));
    }

    // Actualizar racha en BD
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id', // corregido
            'dias_consecutivos' => 'required|integer|min:0',
            'ultima_fecha' => 'nullable|date',
        ]);

        $racha = Racha::findOrFail($id);
        $racha->update($request->all());

        return redirect()->route('admin.rachas.index')->with('success', 'Racha actualizada correctamente.');
    }

    // Eliminar racha (soft delete)
    public function destroy($id)
    {
        $racha = Racha::findOrFail($id);
        $racha->delete();

        return redirect()->route('admin.rachas.index')->with('success', 'Racha eliminada correctamente.');
    }
}
