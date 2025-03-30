<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoPregunta;
use Illuminate\Support\Facades\Validator;

class TipoPreguntaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json(TipoPregunta::all(), 200);
    }

    public function show($id)
    {
        $tipoPregunta = TipoPregunta::find($id);
        if (!$tipoPregunta) {
            return response()->json(['message' => 'Tipo de pregunta no encontrado'], 404);
        }
        return response()->json($tipoPregunta, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $tipoPregunta = TipoPregunta::create($request->all());
        return response()->json($tipoPregunta, 201);
    }

    public function update(Request $request, $id)
    {
        $tipoPregunta = TipoPregunta::find($id);
        if (!$tipoPregunta) {
            return response()->json(['message' => 'Tipo de pregunta no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $tipoPregunta->update($request->all());
        return response()->json($tipoPregunta, 200);
    }

    public function destroy($id)
    {
        $tipoPregunta = TipoPregunta::find($id);
        if (!$tipoPregunta) {
            return response()->json(['message' => 'Tipo de pregunta no encontrado'], 404);
        }

        $tipoPregunta->delete();
        return response()->json(['message' => 'Tipo de pregunta eliminado'], 200);
    }
}
