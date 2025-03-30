<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgresoUsuario;
use Illuminate\Support\Facades\Validator;

class ProgresoUsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $progresos = ProgresoUsuario::all();
        return response()->json($progresos);
    }

    public function show($id)
    {
        $progreso = ProgresoUsuario::find($id);
        if (!$progreso) {
            return response()->json(['message' => 'Progreso no encontrado'], 404);
        }
        return response()->json($progreso);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|exists:usuarios,id',
            'leccion_id' => 'required|exists:lecciones,id',
            'porcentaje_completado' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $progreso = ProgresoUsuario::create($request->all());
        return response()->json($progreso, 201);
    }

    public function update(Request $request, $id)
    {
        $progreso = ProgresoUsuario::find($id);
        if (!$progreso) {
            return response()->json(['message' => 'Progreso no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'porcentaje_completado' => 'sometimes|required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $progreso->update($request->all());
        return response()->json($progreso);
    }

    public function destroy($id)
    {
        $progreso = ProgresoUsuario::find($id);
        if (!$progreso) {
            return response()->json(['message' => 'Progreso no encontrado'], 404);
        }

        $progreso->delete();
        return response()->json(['message' => 'Progreso eliminado correctamente']);
    }
}
