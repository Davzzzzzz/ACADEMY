<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leccion;
use Illuminate\Support\Facades\Validator;

class LeccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json(Leccion::all(), 200);
    }

    public function show($id)
    {
        $leccion = Leccion::find($id);
        if (!$leccion) {
            return response()->json(['message' => 'Lección no encontrada'], 404);
        }
        return response()->json($leccion, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'curso_id' => 'required|exists:cursos,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $leccion = Leccion::create($request->all());
        return response()->json($leccion, 201);
    }

    public function update(Request $request, $id)
    {
        $leccion = Leccion::find($id);
        if (!$leccion) {
            return response()->json(['message' => 'Lección no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'curso_id' => 'sometimes|required|exists:cursos,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $leccion->update($request->all());
        return response()->json($leccion, 200);
    }

    public function destroy($id)
    {
        $leccion = Leccion::find($id);
        if (!$leccion) {
            return response()->json(['message' => 'Lección no encontrada'], 404);
        }

        $leccion->delete();
        return response()->json(['message' => 'Lección eliminada correctamente'], 200);
    }
}
