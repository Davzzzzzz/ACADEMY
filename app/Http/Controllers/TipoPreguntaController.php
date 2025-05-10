<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoPregunta;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="TipoPregunta",
 *     description="Endpoints para gestionar tipos de preguntas"
 * )
 */
class TipoPreguntaController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *   path="/api/tipo_pregunta",
     *   summary="Obtener lista de tipos de preguntas",
     *   tags={"TipoPregunta"},
     *   @OA\Response(
     *     response=200,
     *     description="Lista de tipos de preguntas"
     *   )
     * )
     */
    public function index()
    {
        return response()->json(TipoPregunta::all(), 200);
    }

    /**
     * @OA\Get(
     *   path="/api/tipo_pregunta/{id}",
     *   summary="Obtener un tipo de pregunta por ID",
     *   tags={"TipoPregunta"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Datos del tipo de pregunta"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Tipo de pregunta no encontrado"
     *   )
     * )
     */
    public function show($id)
    {
        $tipoPregunta = TipoPregunta::find($id);
        if (!$tipoPregunta) {
            return response()->json(['message' => 'Tipo de pregunta no encontrado'], 404);
        }
        return response()->json($tipoPregunta, 200);
    }

    /**
     * @OA\Post(
     *   path="/api/tipo_pregunta",
     *   summary="Crear un nuevo tipo de pregunta",
     *   tags={"TipoPregunta"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="nombre", type="string", example="Pregunta Abierta")
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Tipo de pregunta creado"
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Error de validación"
     *   )
     * )
     */
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

    /**
     * @OA\Put(
     *   path="/api/tipo_pregunta/{id}",
     *   summary="Actualizar un tipo de pregunta",
     *   tags={"TipoPregunta"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="nombre", type="string", example="Pregunta Cerrada")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Tipo de pregunta actualizado"
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Error de validación"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Tipo de pregunta no encontrado"
     *   )
     * )
     */
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

    /**
     * @OA\Delete(
     *   path="/api/tipo_pregunta/{id}",
     *   summary="Eliminar un tipo de pregunta",
     *   tags={"TipoPregunta"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Tipo de pregunta eliminado"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Tipo de pregunta no encontrado"
     *   )
     * )
     */
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
