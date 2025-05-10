<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Reportes",
 *     description="Operaciones relacionadas con reportes"
 * )
 */
class ReporteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reportes",
     *     summary="Listar todos los reportes",
     *     tags={"Reportes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de reportes"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Reporte::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/reportes/{id}",
     *     summary="Obtener un reporte por ID",
     *     tags={"Reportes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Reporte encontrado"),
     *     @OA\Response(response=404, description="Reporte no encontrado")
     * )
     */
    public function show($id)
    {
        $reporte = Reporte::find($id);
        if (!$reporte) {
            return response()->json(['message' => 'Reporte no encontrado'], 404);
        }
        return response()->json($reporte, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/reportes",
     *     summary="Crear un nuevo reporte",
     *     tags={"Reportes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_usuario", "descripcion"},
     *             @OA\Property(property="id_usuario", type="integer"),
     *             @OA\Property(property="descripcion", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Reporte creado"),
     *     @OA\Response(response=400, description="Error de validación")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:usuario,id',
            'descripcion' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $reporte = new Reporte();
        $reporte->id_usuario = $request->id_usuario;
        $reporte->descripcion = $request->descripcion;
        $reporte->fecha_reporte = now();
        $reporte->save();

        return response()->json($reporte, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/reportes/{id}",
     *     summary="Actualizar un reporte existente",
     *     tags={"Reportes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="descripcion", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Reporte actualizado"),
     *     @OA\Response(response=400, description="Error de validación"),
     *     @OA\Response(response=404, description="Reporte no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $reporte = Reporte::find($id);
        if (!$reporte) {
            return response()->json(['message' => 'Reporte no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $reporte->descripcion = $request->descripcion;
        $reporte->save();

        return response()->json($reporte, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/reportes/{id}",
     *     summary="Eliminar un reporte",
     *     tags={"Reportes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Reporte eliminado"),
     *     @OA\Response(response=404, description="Reporte no encontrado")
     * )
     */
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
