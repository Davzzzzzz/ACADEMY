<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(Reporte::all(), 200);
    }

    public function show($id)
    {
        $reporte = Reporte::find($id);
        if (!$reporte) {
            return response()->json(['message' => 'Reporte no encontrado'], 404);
        }
        return response()->json($reporte, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|exists:usuarios,id',
            'descripcion' => 'required|string|max:500',
            'estado' => 'required|in:pendiente,resuelto,rechazado'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reporte = Reporte::create($request->all());
        return response()->json($reporte, 201);
    }

    public function update(Request $request, $id)
    {
        $reporte = Reporte::find($id);
        if (!$reporte) {
            return response()->json(['message' => 'Reporte no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'descripcion' => 'sometimes|string|max:500',
            'estado' => 'sometimes|in:pendiente,resuelto,rechazado'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reporte->update($request->all());
        return response()->json($reporte, 200);
    }

    public function destroy($id)
    {
        $reporte = Reporte::find($id);
        if (!$reporte) {
            return response()->json(['message' => 'Reporte no encontrado'], 404);
        }
        $reporte->delete();
        return response()->json(['message' => 'Reporte eliminado'], 200);
    }
}
