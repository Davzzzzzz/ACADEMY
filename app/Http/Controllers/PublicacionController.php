<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Foro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicacionController extends Controller
{
    /**
     * Mostrar una publicación específica junto con sus respuestas.
     */
    public function show($id)
    {
        $publicacion = Publicacion::with(['usuario', 'respuestas.usuario'])->findOrFail($id);
        return view('publicaciones.show', compact('publicacion'));
    }

    /**
     * Mostrar el formulario para crear una nueva publicación o respuesta.
     */
    public function create(Request $request, $foroId)
    {
        $foro = Foro::findOrFail($foroId);
        $parentId = $request->input('parent_id'); // puede ser null

        return view('publicaciones.create', compact('foro', 'parentId'));
    }

    /**
     * Guardar una nueva publicación.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string',
            'foro_id' => 'required|exists:foros,id',
            'parent_id' => 'nullable|exists:publicaciones,id',
        ]);

        // Usar el id numérico del usuario autenticado (nunca el correo)
        $user = Auth::user();
        $userId = $user->id; // Asegúrate de que tu modelo Usuario tenga el campo id

        Publicacion::create([
            'id_usuario' => $userId,
            'foro_id' => $request->foro_id,
            'parent_id' => $request->parent_id,
            'contenido' => $request->contenido,
        ]);

        return redirect()->back()->with('success', 'Publicación enviada con éxito.');
    }

    /**
     * Mostrar formulario para editar una publicación.
     */
    public function edit($id)
    {
        $publicacion = Publicacion::findOrFail($id);

        if (Auth::id() !== $publicacion->id_usuario) {
            abort(403, 'No autorizado.');
        }

        return view('publicaciones.edit', compact('publicacion'));
    }

    /**
     * Actualizar el contenido de una publicación.
     */
    public function update(Request $request, $id)
    {
        $publicacion = Publicacion::findOrFail($id);

        if (Auth::id() !== $publicacion->id_usuario) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'contenido' => 'required|string',
        ]);

        $publicacion->update([
            'contenido' => $request->contenido,
        ]);

        return redirect()->back()->with('success', 'Publicación actualizada.');
    }

    /**
     * Eliminar (opcionalmente soft-delete) una publicación.
     */
    public function destroy($id)
    {
        $publicacion = Publicacion::findOrFail($id);

        if (Auth::id() !== $publicacion->id_usuario) {
            abort(403, 'No autorizado.');
        }

        $publicacion->delete();

        return redirect()->back()->with('success', 'Publicación eliminada.');
    }
}
