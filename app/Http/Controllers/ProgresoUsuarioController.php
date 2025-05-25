<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgresoUsuario;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="ProgresoUsuario",
 *     description="Operaciones sobre el progreso del usuario en las lecciones"
 * )
 */
class ProgresoUsuarioController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/progreso-usuarios",
     *     summary="Listar todos los progresos de los usuarios",
     *     tags={"ProgresoUsuario"},
     *     @OA\Response(response=200, description="Lista de progresos")
     * )
     */
    public function index()
    {
        $progresos = ProgresoUsuario::all();
        return response()->json($progresos);
    }

    /**
     * @OA\Get(
     *     path="/api/progreso-usuarios/{id}",
     *     summary="Obtener un progreso específico por ID",
     *     tags={"ProgresoUsuario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del progreso del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Progreso encontrado"),
     *     @OA\Response(response=404, description="Progreso no encontrado")
     * )
     */
    public function show($id)
    {
        $progreso = ProgresoUsuario::find($id);
        if (!$progreso) {
            return response()->json(['message' => 'Progreso no encontrado'], 404);
        }
        return response()->json($progreso);
    }

    /**
     * @OA\Post(
     *     path="/api/progreso-usuarios",
     *     summary="Registrar un nuevo progreso de usuario",
     *     tags={"ProgresoUsuario"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_usuario", "id_leccion_actual", "ejercicios_completados"},
     *             @OA\Property(property="id_usuario", type="integer", example=1),
     *             @OA\Property(property="id_nivel", type="integer", example=2),
     *             @OA\Property(property="id_leccion_actual", type="integer", example=3),
     *             @OA\Property(property="ejercicios_completados", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Progreso creado exitosamente"),
     *     @OA\Response(response=400, description="Errores de validación")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|integer|exists:usuarios,id',
            'id_nivel' => 'required|integer|exists:niveles,id_nivel',
            'id_leccion_actual' => 'required|integer|exists:lecciones,id_leccion',
            'ejercicios_completados' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $progreso = ProgresoUsuario::create([
            'id_usuario' => $request->id_usuario,
            'id_nivel' => $request->id_nivel,
            'id_leccion_actual' => $request->id_leccion_actual,
            'ejercicios_completados' => $request->ejercicios_completados,
        ]);

        return response()->json($progreso, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/progreso-usuarios/{id}",
     *     summary="Actualizar un progreso de usuario",
     *     tags={"ProgresoUsuario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del progreso del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id_nivel", type="integer", example=2),
     *             @OA\Property(property="id_leccion_actual", type="integer", example=4),
     *             @OA\Property(property="ejercicios_completados", type="integer", example=20)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Progreso actualizado"),
     *     @OA\Response(response=400, description="Errores de validación"),
     *     @OA\Response(response=404, description="Progreso no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $progreso = ProgresoUsuario::find($id);
        if (!$progreso) {
            return response()->json(['message' => 'Progreso no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_nivel' => 'sometimes|required|integer|exists:niveles,id_nivel',
            'id_leccion_actual' => 'sometimes|required|integer|exists:lecciones,id_leccion',
            'ejercicios_completados' => 'sometimes|required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $progreso->update($request->all());
        return response()->json($progreso);
    }

    /**
     * @OA\Delete(
     *     path="/api/progreso-usuarios/{id}",
     *     summary="Eliminar un progreso de usuario",
     *     tags={"ProgresoUsuario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del progreso del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Progreso eliminado correctamente"),
     *     @OA\Response(response=404, description="Progreso no encontrado")
     * )
     */
    public function destroy($id)
    {
        $progreso = ProgresoUsuario::find($id);
        if (!$progreso) {
            return response()->json(['message' => 'Progreso no encontrado'], 404);
        }

        $progreso->delete();
        return response()->json(['message' => 'Progreso eliminado correctamente']);
    }

    public function sumarEjercicio(Request $request){
    $userId = auth()->id();
    $progreso = \App\Models\ProgresoUsuario::where('id_usuario', $userId)->first();

    if ($progreso) {
        $progreso->ejercicios_completados += 1;
        $progreso->save();
    } else {
        // Si no existe, lo crea (ajusta id_nivel e id_leccion_actual según tu lógica)
        $progreso = \App\Models\ProgresoUsuario::create([
            'id_usuario' => $userId,
            'id_nivel' => 1,
            'id_leccion_actual' => $request->id_leccion_actual ?? 1,
            'ejercicios_completados' => 1,
        ]);
    }

    return response()->json(['ok' => true, 'ejercicios_completados' => $progreso->ejercicios_completados]);
}
}
