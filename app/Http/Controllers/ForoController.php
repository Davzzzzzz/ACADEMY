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
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(Foro::all(), 200);
    }

    public function show($id)
    {
        $foro = Foro::find($id);
        if (!$foro) {
            return response()->json(['error' => 'Foro no encontrado'], 404);
        }
        return response()->json($foro, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $foro = Foro::create($request->all());
        return response()->json($foro, 201);
    }

    public function update(Request $request, $id)
    {
        $foro = Foro::find($id);
        if (!$foro) {
            return response()->json(['error' => 'Foro no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $foro->update($request->all());
        return response()->json($foro, 200);
    }

    public function destroy($id)
    {
        $foro = Foro::find($id);
        if (!$foro) {
            return response()->json(['error' => 'Foro no encontrado'], 404);
        }

        $foro->delete();
        return response()->json(['message' => 'Foro eliminado'], 200);
    }
}
