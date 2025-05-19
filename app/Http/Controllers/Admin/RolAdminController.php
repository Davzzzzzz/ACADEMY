<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolAdminController extends Controller
{
    /**
     * Mostrar listado de roles.
     */
    public function index()
    {
        $roles = Rol::with('usuarios')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Mostrar formulario para crear un nuevo rol.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Guardar nuevo rol en base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre',
        ]);

        Rol::create($request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }

    /**
     * Mostrar detalles de un rol.
     */
    public function show($id)
    {
        $rol = Rol::with('usuarios')->findOrFail($id);
        return view('admin.roles.show', compact('rol'));
    }

    /**
     * Mostrar formulario para editar un rol.
     */
    public function edit($id)
    {
        $rol = Rol::findOrFail($id);
        return view('admin.roles.edit', compact('rol'));
    }

    /**
     * Actualizar un rol en base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $id,
        ]);

        $rol = Rol::findOrFail($id);
        $rol->update($request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Eliminar un rol.
     */
    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
