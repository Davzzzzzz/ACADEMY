<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ejercicio;
use App\Models\Leccion;
use Illuminate\Support\Facades\Storage;

class EjercicioAdminController extends Controller
{
    public function index()
    {
        // Usar paginación
        $ejercicios = Ejercicio::with('leccion')->paginate(5);
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
            'opciones_texto' => 'nullable|array',
            'opciones_texto.*' => 'nullable|string',
            'opciones_imagen' => 'nullable|array',
            'opciones_imagen.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'respuesta_correcta' => 'required|string',
        ]);

        // Imagen de la pregunta
        $rutaImagenPregunta = null;
        if ($request->hasFile('imagen_pregunta')) {
            $nombreImagen = 'pregunta_' . time() . '.' . $request->file('imagen_pregunta')->getClientOriginalExtension();
            $rutaImagenPregunta = $request->file('imagen_pregunta')->storeAs('public/ejercicios', $nombreImagen);
        }

        // Opciones
        $opcionesFormateadas = [];

        $opcionesTexto = $request->opciones_texto ?? [];
        $opcionesImagenes = $request->file('opciones_imagen') ?? [];

        foreach ($opcionesTexto as $index => $texto) {
            $imagenRuta = null;

            if (isset($opcionesImagenes[$index])) {
                // Definir nombre fijo o personalizado
                $nombreImagen = chr(97 + $index) . '.png'; // a.png, b.png, c.png...
                $imagenRuta = $opcionesImagenes[$index]->storeAs('public/opciones', $nombreImagen);
            }

            $opcionesFormateadas[] = [
                'label' => $texto,
                'imagen' => $imagenRuta ? str_replace('public/', 'storage/', $imagenRuta) : null
            ];
        }

        // Guardar ejercicio
        Ejercicio::create([
            'id_leccion' => $request->id_leccion,
            'id_tipo_pregunta' => $request->id_tipo_pregunta,
            'pregunta' => $request->pregunta,
            'imagen_pregunta' => $rutaImagenPregunta ? str_replace('public/', 'storage/', $rutaImagenPregunta) : null,
            'opciones' => $opcionesFormateadas,
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
            'opciones_texto' => 'nullable|array',
            'opciones_texto.*' => 'nullable|string',
            'opciones_imagen' => 'nullable|array',
            'opciones_imagen.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'respuesta_correcta' => 'required|string',
        ]);

        // Imagen de la pregunta
        if ($request->hasFile('imagen_pregunta')) {
            $nombreImagen = 'pregunta_' . time() . '.' . $request->file('imagen_pregunta')->getClientOriginalExtension();
            $rutaImagenPregunta = $request->file('imagen_pregunta')->storeAs('public/ejercicios', $nombreImagen);
            $ejercicio->imagen_pregunta = str_replace('public/', 'storage/', $rutaImagenPregunta);
        }

        // Opciones
        $opcionesFormateadas = [];

        $opcionesTexto = $request->opciones_texto ?? [];
        $opcionesImagenes = $request->file('opciones_imagen') ?? [];

        foreach ($opcionesTexto as $index => $texto) {
            $imagenRuta = null;

            if (isset($opcionesImagenes[$index])) {
                $nombreImagen = chr(97 + $index) . '.png'; // a.png, b.png, c.png...
                $imagenRuta = $opcionesImagenes[$index]->storeAs('public/opciones', $nombreImagen);
            }

            $opcionesFormateadas[] = [
                'label' => $texto,
                'imagen' => $imagenRuta ? str_replace('public/', 'storage/', $imagenRuta) : null
            ];
        }

        $ejercicio->update([
            'id_leccion' => $request->id_leccion,
            'id_tipo_pregunta' => $request->id_tipo_pregunta,
            'pregunta' => $request->pregunta,
            'opciones' => $opcionesFormateadas,
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
