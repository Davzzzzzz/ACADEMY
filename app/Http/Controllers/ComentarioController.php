<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use Illuminate\Support\Facades\Validator;

class ComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(Comentario::all(), 200);
    }

    public function show($id)
    {
        $comentario = Comentario::find($id);
        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }
        return response()->json($comentario, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|integer',
            'id_foro' => 'required|integer',
            'contenido' => 'required|string',
            'fecha_publicacion' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $comentario = Comentario::create($request->all());
        return response()->json($comentario, 201);
    }

    public function update(Request $request, $id)
    {
        $comentario = Comentario::find($id);
        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'contenido' => 'sometimes|string',
            'fecha_publicacion' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $comentario->update($request->all());
        return response()->json($comentario, 200);
    }

    public function destroy($id)
    {
        $comentario = Comentario::find($id);
        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        $comentario->delete();
        return response()->json(['message' => 'Comentario eliminado'], 200);
    }
}
