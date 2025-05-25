<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class UsuarioAdminController extends Controller
{
    public function index()
    {
        // Ejemplo en tu controlador
        $usuarios = Usuario::with('rol')->paginate(10); // o el número que prefieras
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
    $roles = Rol::all();
    return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuario,correo',
            'contrasena' => 'required|string|min:2',
            'id_rol' => 'required|integer',
        ]);

        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->contrasena = bcrypt($request->contrasena);
        $usuario->fecha_registro = now();
        $usuario->id_rol = $request->id_rol;
        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }


    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
{
    $usuario = Usuario::findOrFail($id);

    // Validación de los datos recibidos
    $request->validate([
        'nombre' => 'required|string|max:100',
        'correo' => 'required|email|unique:usuario,correo,' . $usuario->id,
        'id_rol' => 'required|exists:roles,id',
    ]);

    // Asignar los nuevos valores
    $usuario->nombre = $request->nombre;
    $usuario->correo = $request->correo;
    $usuario->id_rol = $request->id_rol;

    // Solo actualizar contraseña si se escribió una nueva
    if ($request->filled('contrasena')) {
        $usuario->contrasena = bcrypt($request->contrasena);
    }

    $usuario->save();

    return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente');
}


    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
