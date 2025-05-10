<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leccion;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Lecciones",
 *     description="Gestión de lecciones"
 * )
 */
class LeccionController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/lecciones",
     *     summary="Listar todas las lecciones",
     *     tags={"Lecciones"},
     *     @OA\Response(response=200, description="Lista de lecciones")
     * )
     */
    public function index()
    {
        return response()->json(Leccion::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/lecciones/{id}",
     *     summary="Obtener una lección específica",
     *     tags={"Lecciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la lección",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Lección encontrada"),
     *     @OA\Response(response=404, description="Lección no encontrada")
     * )
     */
    public function show($id)
    {
        $leccion = Leccion::where('id_leccion', $id)->firstOrFail();
        if (!$leccion) {
            return response()->json(['message' => 'Lección no encontrada'], 404);
        }
        return response()->json($leccion, 200);
    }

/**
 * @OA\Post(
 *     path="/api/lecciones",
 *     summary="Crear una nueva lección",
 *     tags={"Lecciones"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"titulo", "id_nivel"},
 *             @OA\Property(property="titulo", type="string", example="Lección 1"),
 *             @OA\Property(property="contenido", type="string", example="Contenido de la lección"),
 *             @OA\Property(property="id_nivel", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(response=201, description="Lección creada"),
 *     @OA\Response(response=422, description="Errores de validación")
 * )
 */



 public function store(Request $request)
 {
    $validator = Validator::make($request->all(), [
        'titulo'    => 'required|string|max:255',
        'contenido' => 'nullable|string',
        'id_nivel'  => 'required|exists:niveles,id_nivel'
    ]);


     if ($validator->fails()) {
         return response()->json(['errors' => $validator->errors()], 422);
     }

     $leccion = Leccion::create($request->all());

     return response()->json($leccion, 201);
 }

    /**
     * @OA\Put(
     *     path="/api/lecciones/{id}",
     *     summary="Actualizar una lección existente",
     *     tags={"Lecciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la lección",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="titulo", type="string", example="Lección actualizada"),
     *             @OA\Property(property="descripcion", type="string", example="Contenido actualizado"),
     *             @OA\Property(property="curso_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Lección actualizada"),
     *     @OA\Response(response=404, description="Lección no encontrada"),
     *     @OA\Response(response=422, description="Errores de validación")
     * )
     */
    public function update(Request $request, $id)
    {
        $leccion = Leccion::where('id_leccion', $id)->firstOrFail();
        if (!$leccion) {
            return response()->json(['message' => 'Lección no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'id_nivel' => 'sometimes|required|exists:cursos,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $leccion->update($request->all());
        return response()->json($leccion, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/lecciones/{id}",
     *     summary="Eliminar una lección",
     *     tags={"Lecciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la lección",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Lección eliminada correctamente"),
     *     @OA\Response(response=404, description="Lección no encontrada")
     * )
     */
    public function destroy($id)
    {
        $leccion = Leccion::where('id_leccion', $id)->firstOrFail();
        if (!$leccion) {
            return response()->json(['message' => 'Lección no encontrada'], 404);
        }

        $leccion->delete();
        return response()->json(['message' => 'Lección eliminada correctamente'], 200);
    }
}
