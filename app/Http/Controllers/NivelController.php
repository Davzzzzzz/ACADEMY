<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nivel;
use Illuminate\Support\Facades\Validator;

class NivelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return response()->json(Nivel::all(), 200);
    }

    public function show($id)
    {
        $nivel = Nivel::find($id);
        if (!$nivel) {
            return response()->json(['message' => 'Nivel no encontrado'], 404);
        }
        return response()->json($nivel, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $nivel = Nivel::create($request->all());
        return response()->json($nivel, 201);
    }

    public function update(Request $request, $id)
    {
        $nivel = Nivel::find($id);
        if (!$nivel) {
            return response()->json(['message' => 'Nivel no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $nivel->update($request->all());
        return response()->json($nivel, 200);
    }

    public function destroy($id)
    {
        $nivel = Nivel::find($id);
        if (!$nivel) {
            return response()->json(['message' => 'Nivel no encontrado'], 404);
        }

        $nivel->delete();
        return response()->json(['message' => 'Nivel eliminado'], 200);
    }
}
