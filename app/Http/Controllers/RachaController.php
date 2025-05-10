<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Racha;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Rachas",
 *     description="Operaciones relacionadas con las rachas de usuarios"
 * )
 */
class RachaController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/rachas",
     *     summary="Listar todas las rachas",
     *     tags={"Rachas"},
     *     @OA\Response(response=200, description="Lista de rachas")
     * )
     */
    public function index()
    {
        return response()->json(Racha::all());
    }

    /**
     * @OA\Get(
     *     path="/api/rachas/{id}",
     *     summary="Obtener una racha por ID",
     *     tags={"Rachas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la racha",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Racha encontrada"),
     *     @OA\Response(response=404, description="Racha no encontrada")
     * )
     */
    public function show($id)
    {
        $racha = Racha::find($id);
        if (!$racha) {
            return response()->json(['message' => 'Racha no encontrada'], 404);
        }
        return response()->json($racha);
    }

    /**
     * @OA\Post(
     *     path="/api/rachas",
     *     summary="Crear una nueva racha",
     *     tags={"Rachas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_usuario", "dias_consecutivos"},
     *             @OA\Property(property="id_usuario", type="integer", example=2),
     *             @OA\Property(property="dias_consecutivos", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Racha creada"),
     *     @OA\Response(response=400, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_usuario' => 'required|integer|exists:usuario,id',
        'dias_consecutivos' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    $racha = Racha::create([
        'id_usuario' => $request->id_usuario,
        'dias_consecutivos' => $request->dias_consecutivos,
    ]);

    return response()->json($racha, 201);
}


    /**
     * @OA\Put(
     *     path="/api/rachas/{id}",
     *     summary="Actualizar una racha existente",
     *     tags={"Rachas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la racha",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"dias_consecutivos"},
     *             @OA\Property(property="dias_consecutivos", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Racha actualizada"),
     *     @OA\Response(response=400, description="Datos inválidos"),
     *     @OA\Response(response=404, description="Racha no encontrada")
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'dias_consecutivos' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $racha = Racha::find($id);
        if (!$racha) {
            return response()->json(['message' => 'Racha no encontrada'], 404);
        }

        $racha->update($request->only('dias_consecutivos'));

        return response()->json($racha);
    }

    /**
     * @OA\Delete(
     *     path="/api/rachas/{id}",
     *     summary="Eliminar una racha",
     *     tags={"Rachas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la racha",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Racha eliminada correctamente"),
     *     @OA\Response(response=404, description="Racha no encontrada")
     * )
     */
    public function destroy($id)
    {
        $racha = Racha::find($id);
        if (!$racha) {
            return response()->json(['message' => 'Racha no encontrada'], 404);
        }

        $racha->delete();
        return response()->json(['message' => 'Racha eliminada correctamente']);
    }
}
