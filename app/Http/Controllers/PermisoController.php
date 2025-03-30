<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permiso;
use Illuminate\Support\Facades\Validator;

class PermisoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json(Permiso::all(), 200);
    }

    public function show($id)
    {
        $permiso = Permiso::find($id);
        if (!$permiso) {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }
        return response()->json($permiso, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:permisos,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $permiso = Permiso::create($request->all());
        return response()->json($permiso, 201);
    }

    public function update(Request $request, $id)
    {
        $permiso = Permiso::find($id);
        if (!$permiso) {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:100|unique:permisos,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $permiso->update($request->all());
        return response()->json($permiso, 200);
    }

    public function destroy($id)
    {
        $permiso = Permiso::find($id);
        if (!$permiso) {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }
        $permiso->delete();
        return response()->json(['message' => 'Permiso eliminado correctamente'], 200);
    }
}

