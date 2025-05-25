<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foro;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ForoController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth:sanctum');
    }

    // Mostrar todos los foros
    public function index(){
    $foros = Foro::withCount('comentarios')->get();
    return view('foros.index', compact('foros'));}

    // Mostrar el formulario para crear un nuevo foro
    public function create()
    {
        return view('foros.create');
    }

    // Almacenar el nuevo foro
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $foro = new Foro();
        $foro->titulo = $request->titulo;
        $foro->descripcion = $request->descripcion;
        $foro->fecha_creacion = now(); // ✅ esta línea soluciona tu error
        $foro->save();

        if ($request->wantsJson()) {
            return response()->json($foro, 201);
        }

        return redirect()->route('foros.index')->with('success', 'Foro creado exitosamente.');
    }

    // Mostrar un foro específico
    public function show($id)
{
    $foro = Foro::with(['publicaciones.usuario'])->findOrFail($id);
    return view('foros.show', compact('foro'));
}

    // Mostrar formulario para editar
    public function edit($id)
    {
        $foro = Foro::findOrFail($id);

        // Asegura que solo el dueño pueda editarlo (opcional)
        if (Auth::id() !== $foro->usuario_id) {
            abort(403, 'No autorizado.');
        }

        return view('foros.edit', compact('foro'));
    }

    // Actualizar foro
    public function update(Request $request, $id)
    {
        $foro = Foro::findOrFail($id);

        if (Auth::id() !== $foro->usuario_id) {
            abort(403, 'No autorizado.');
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $foro->titulo = $request->titulo;
        $foro->contenido = $request->descripcion;
        $foro->save();

        if ($request->wantsJson()) {
            return response()->json($foro);
        }

        return redirect()->route('foros.index')->with('success', 'Foro actualizado exitosamente.');
    }

    // Eliminar foro
    public function destroy($id)
    {
        $foro = Foro::findOrFail($id);

        if (Auth::id() !== $foro->usuario_id) {
            abort(403, 'No autorizado.');
        }

        $foro->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Foro eliminado']);
        }

        return redirect()->route('foros.index')->with('success', 'Foro eliminado.');
    }
}
