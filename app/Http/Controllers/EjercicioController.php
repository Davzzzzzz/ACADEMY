<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejercicio;
use Illuminate\Support\Facades\Validator;

class EjercicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json(Ejercicio::all(), 200);
    }

    public function show($id)
    {
        $ejercicio = Ejercicio::find($id);
        if (!$ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado'], 404);
        }
        return response()->json($ejercicio, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel' => 'required|string|in:principiante,intermedio,avanzado',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $ejercicio = Ejercicio::create($request->all());
        return response()->json($ejercicio, 201);
    }

    public function update(Request $request, $id)
    {
        $ejercicio = Ejercicio::find($id);
        if (!$ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel' => 'sometimes|required|string|in:principiante,intermedio,avanzado',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $ejercicio->update($request->all());
        return response()->json($ejercicio, 200);
    }

    public function destroy($id)
    {
        $ejercicio = Ejercicio::find($id);
        if (!$ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado'], 404);
        }

        $ejercicio->delete();
        return response()->json(['message' => 'Ejercicio eliminado correctamente'], 200);
    }
}
