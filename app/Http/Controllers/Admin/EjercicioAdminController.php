<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ejercicio;
use App\Models\Leccion;

class EjercicioAdminController extends Controller
{
    public function index()
    {
        $ejercicios = Ejercicio::with('leccion')->get();
        return view('admin.ejercicios.index', compact('ejercicios'));
    }

    public function create()
    {
        $lecciones = Leccion::all();
        return view('admin.ejercicios.create', compact('lecciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_leccion' => 'required|exists:lecciones,id_leccion',
            'id_tipo_pregunta' => 'required|integer',
            'pregunta' => 'required|string',
            'imagen_pregunta' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'opciones' => 'required|array|min:1',
            'opciones.*' => 'required|string',
            'respuesta_correcta' => 'required|string',
        ]);

        $rutaImagen = null;
        if ($request->hasFile('imagen_pregunta')) {
            $rutaImagen = $request->file('imagen_pregunta')->store('ejercicios', 'public');
        }

        // Formatear las opciones como array de objetos con 'label'
        $opcionesFormateadas = array_map(fn($opcion) => ['label' => $opcion], $request->opciones);

        Ejercicio::create([
            'id_leccion' => $request->id_leccion,
            'id_tipo_pregunta' => $request->id_tipo_pregunta,
            'pregunta' => $request->pregunta,
            'imagen_pregunta' => $rutaImagen,
            'opciones' => $opcionesFormateadas, // ❌ NO usar json_encode
            'respuesta_correcta' => $request->respuesta_correcta,
        ]);

        return redirect()->route('admin.ejercicios.index')->with('success', 'Ejercicio creado correctamente.');
    }

    public function show($id)
    {
        $ejercicio = Ejercicio::with('leccion')->findOrFail($id);
        return view('admin.ejercicios.show', compact('ejercicio'));
    }

    public function edit($id)
    {
        $ejercicio = Ejercicio::findOrFail($id);
        $lecciones = Leccion::all();
        return view('admin.ejercicios.edit', compact('ejercicio', 'lecciones'));
    }

    public function update(Request $request, $id)
    {
        $ejercicio = Ejercicio::findOrFail($id);

        $request->validate([
            'id_leccion' => 'required|exists:lecciones,id_leccion',
            'id_tipo_pregunta' => 'required|integer',
            'pregunta' => 'required|string',
            'imagen_pregunta' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'opciones' => 'required|array|min:1',
            'opciones.*' => 'required|string',
            'respuesta_correcta' => 'required|string',
        ]);

        if ($request->hasFile('imagen_pregunta')) {
            $rutaImagen = $request->file('imagen_pregunta')->store('ejercicios', 'public');
            $ejercicio->imagen_pregunta = $rutaImagen;
        }

        // Formatear las opciones como array de objetos con 'label'
        $opcionesFormateadas = array_map(fn($opcion) => ['label' => $opcion], $request->opciones);

        $ejercicio->update([
            'id_leccion' => $request->id_leccion,
            'id_tipo_pregunta' => $request->id_tipo_pregunta,
            'pregunta' => $request->pregunta,
            'opciones' => $opcionesFormateadas, // ❌ NO usar json_encode
            'respuesta_correcta' => $request->respuesta_correcta,
        ]);

        return redirect()->route('admin.ejercicios.index')->with('success', 'Ejercicio actualizado correctamente.');
    }

    public function destroy($id)
    {
        $ejercicio = Ejercicio::findOrFail($id);
        $ejercicio->delete();

        return redirect()->route('admin.ejercicios.index')->with('success', 'Ejercicio eliminado correctamente.');
    }
}
