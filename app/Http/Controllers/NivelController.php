<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nivel;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Niveles",
 *     description="Gestión de niveles"
 * )
 */
class NivelController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/niveles",
     *     summary="Listar todos los niveles",
     *     tags={"Niveles"},
     *     @OA\Response(response=200, description="Lista de niveles")
     * )
     */
    public function index()
    {
        return response()->json(Nivel::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/niveles/{id}",
     *     summary="Obtener un nivel específico",
     *     tags={"Niveles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del nivel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Nivel encontrado"),
     *     @OA\Response(response=404, description="Nivel no encontrado")
     * )
     */
    public function show($id)
    {
        $nivel = Nivel::find($id);
        if (!$nivel) {
            return response()->json(['message' => 'Nivel no encontrado'], 404);
        }
        return response()->json($nivel, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/niveles",
     *     summary="Crear un nuevo nivel",
     *     tags={"Niveles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="Nivel Básico"),
     *             @OA\Property(property="descripcion", type="string", example="Primer nivel de dificultad")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Nivel creado exitosamente"),
     *     @OA\Response(response=400, description="Errores de validación")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/niveles/{id}",
     *     summary="Actualizar un nivel existente",
     *     tags={"Niveles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del nivel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Nivel Intermedio"),
     *             @OA\Property(property="descripcion", type="string", example="Segundo nivel de dificultad")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Nivel actualizado exitosamente"),
     *     @OA\Response(response=400, description="Errores de validación"),
     *     @OA\Response(response=404, description="Nivel no encontrado")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/niveles/{id}",
     *     summary="Eliminar un nivel",
     *     tags={"Niveles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del nivel",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Nivel eliminado"),
     *     @OA\Response(response=404, description="Nivel no encontrado")
     * )
     */
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
