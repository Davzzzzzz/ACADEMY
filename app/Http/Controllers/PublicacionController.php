<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicacionController extends Controller
{
    /**
     * Mostrar una publicación específica (opcional)
     */
    public function show($id)
    {
        $publicacion = Publicacion::with(['usuario', 'respuestas.usuario'])->findOrFail($id);
        return view('publicaciones.show', compact('publicacion'));
    }

    /**
     * Almacenar una nueva publicación o respuesta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string',
            'foro_id' => 'required|exists:foros,id',
            'parent_id' => 'nullable|exists:publicaciones,id',
        ]);

        Publicacion::create([
            'id_usuario' => Auth::id(),
            'foro_id' => $request->foro_id,
            'parent_id' => $request->parent_id,
            'contenido' => $request->contenido,
        ]);

        return redirect()->back()->with('success', 'Publicación enviada con éxito.');
    }

    /**
     * Mostrar el formulario para editar una publicación (opcional)
     */
    public function edit($id)
{
    $publicacion = Publicacion::findOrFail($id);

    // Opcional: Verificar si el usuario tiene permiso para editar
    if (auth()->id() !== $publicacion->usuario_id) {
        abort(403, 'No autorizado');
    }

    return view('publicaciones.edit', compact('publicacion'));
}

public function update(Request $request, $id)
{
    $publicacion = Publicacion::findOrFail($id);

    if (auth()->id() !== $publicacion->usuario_id) {
        abort(403, 'No autorizado');
    }

    $request->validate([
        'contenido' => 'required|string',
    ]);

    $publicacion->contenido = $request->contenido;
    $publicacion->save();

    return redirect()->back()->with('success', 'Publicación actualizada.');
}


    /**
     * Eliminar una publicación.
     */
    public function destroy($id)
    {
        $publicacion = Publicacion::findOrFail($id);

        if ($publicacion->id_usuario !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        $publicacion->delete();

        return redirect()->back()->with('success', 'Publicación eliminada.');
    }
}
