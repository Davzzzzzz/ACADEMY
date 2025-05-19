<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
        // $this->middleware('admin')->only(['destroy']);
    }

    /**
     * Mostrar todos los usuarios (vista o API).
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.dashboard', compact('usuarios'));
    }

    /**
     * Mostrar el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Guardar un nuevo usuario en la base de datos.
     */
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

        return redirect()->route('dashboard')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar un usuario por su ID (API).
     */
    public function show($id)
    {
        return response()->json(Usuario::findOrFail($id));
    }

    /**
     * Mostrar el formulario de edición para un usuario.
     */
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.edit', compact('usuario'));
    }

    /**
     * Actualizar los datos de un usuario.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'correo' => 'sometimes|required|email|unique:usuario,correo,' . $usuario->id . ',id',
            'contrasena' => 'sometimes|nullable|string|min:2',
            'id_rol' => 'sometimes|required|integer',
        ]);

        $usuario->nombre = $request->nombre ?? $usuario->nombre;
        $usuario->correo = $request->correo ?? $usuario->correo;

        if ($request->filled('contrasena')) {
            $usuario->contrasena = bcrypt($request->contrasena);
        }

        $usuario->id_rol = $request->id_rol ?? $usuario->id_rol;
        $usuario->save();

        return redirect()->route('dashboard')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario (borrado lógico o físico).
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return redirect()->route('dashboard')->with('error', 'Usuario no encontrado.');
        }

        $usuario->delete();

        return redirect()->route('dashboard')->with('success', 'Usuario eliminado correctamente.');
    }
}
