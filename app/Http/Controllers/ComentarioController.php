<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Comentarios",
 *     description="Operaciones relacionadas con los comentarios del foro"
 * )
 */
class ComentarioController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/comentarios",
     *     summary="Listar todos los comentarios",
     *     tags={"Comentarios"},
     *     @OA\Response(response=200, description="Lista de comentarios")
     * )
     */
    public function index()
    {
        return response()->json(Comentario::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/comentarios/{id}",
     *     summary="Obtener un comentario por ID",
     *     tags={"Comentarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Comentario encontrado"),
     *     @OA\Response(response=404, description="Comentario no encontrado")
     * )
     */
    public function show($id)
    {
        $comentario = Comentario::find($id);
        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }
        return response()->json($comentario, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/comentarios",
     *     summary="Crear un nuevo comentario",
     *     tags={"Comentarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_usuario", "foro_id", "contenido", "fecha_publicacion"},
     *             @OA\Property(property="id_usuario", type="integer", example=1),
     *             @OA\Property(property="foro_id", type="integer", example=5),
     *             @OA\Property(property="contenido", type="string", example="Este es un comentario de ejemplo."),
     *             @OA\Property(property="fecha_publicacion", type="string", format="date", example="2025-04-05")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Comentario creado correctamente"),
     *     @OA\Response(response=400, description="Errores de validación")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|integer',
            'foro_id' => 'required|integer',
            'contenido' => 'required|string',
            'fecha_publicacion' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $comentario = Comentario::create($request->all());
        return response()->json($comentario, 201);
    }

   /**
     * @OA\Put(
     *     path="/api/comentarios/{id}",
     *     summary="Actualizar un comentario",
     *     tags={"Comentarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contenido", "fecha_publicacion"},
     *             @OA\Property(property="contenido", type="string", example="Este es un comentario actualizado."),
     *             @OA\Property(property="fecha_publicacion", type="string", example="2025-04-30")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Comentario actualizado correctamente"),
     *     @OA\Response(response=400, description="Errores de validación"),
     *     @OA\Response(response=404, description="Comentario no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        // Buscar el comentario por la columna 'id', que es la clave primaria por defecto
        $comentario = Comentario::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        // Validación de los campos
        $validator = Validator::make($request->all(), [
            'contenido' => 'sometimes|string',
            'fecha_publicacion' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Actualizamos el comentario con los datos recibidos
        $comentario->update($request->all());

        return response()->json($comentario, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/comentarios/{id}",
     *     summary="Eliminar un comentario",
     *     tags={"Comentarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Comentario eliminado correctamente"),
     *     @OA\Response(response=404, description="Comentario no encontrado")
     * )
     */
    public function destroy($id)
    {
        // Buscar el comentario por la columna 'id', que es la clave primaria por defecto
        $comentario = Comentario::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        // Eliminamos el comentario
        $comentario->delete();

        return response()->json(['message' => 'Comentario eliminado correctamente'], 200);
    }
}
