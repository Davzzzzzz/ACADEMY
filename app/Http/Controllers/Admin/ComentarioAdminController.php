<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use App\Models\Usuario;
use App\Models\Foro;
use Illuminate\Http\Request;

class ComentarioAdminController extends Controller
{
    // Mostrar lista de comentarios
    public function index()
    {
        $comentarios = Comentario::with(['usuario', 'foro'])->paginate(10);
        return view('admin.comentarios.index', compact('comentarios'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $usuarios = Usuario::all();
        $foros = Foro::all();
        return view('admin.comentarios.create', compact('usuarios', 'foros'));
    }

    // Guardar nuevo comentario
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id',
            'foro_id' => 'required|exists:foros,id',
            'contenido' => 'required|string|max:1000',
        ]);

        Comentario::create([
            'id_usuario' => $request->id_usuario,
            'foro_id' => $request->foro_id,
            'contenido' => $request->contenido,
            'fecha_publicacion' => now(),
        ]);

        return redirect()->route('admin.comentarios.index')->with('success', 'Comentario creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $comentario = Comentario::findOrFail($id);
        $usuarios = Usuario::all();
        $foros = Foro::all();
        return view('admin.comentarios.edit', compact('comentario', 'usuarios', 'foros'));
    }

    // Actualizar comentario existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuario,id',
            'foro_id' => 'required|exists:foros,id',
            'contenido' => 'required|string|max:1000',
            'fecha_publicacion' => 'required|date',
        ]);

        $comentario = Comentario::findOrFail($id);
        $comentario->update([
            'id_usuario' => $request->id_usuario,
            'foro_id' => $request->foro_id,
            'contenido' => $request->contenido,
            'fecha_publicacion' => $request->fecha_publicacion,
        ]);

        return redirect()->route('admin.comentarios.index')->with('success', 'Comentario actualizado correctamente.');
    }

    // Eliminar comentario
    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return redirect()->route('admin.comentarios.index')->with('success', 'Comentario eliminado.');
    }
}
