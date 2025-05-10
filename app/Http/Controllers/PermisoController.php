<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permiso;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Permisos",
 *     description="Gestión de permisos en el sistema"
 * )
 */
class PermisoController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/permisos",
     *     summary="Listar todos los permisos",
     *     tags={"Permisos"},
     *     @OA\Response(response=200, description="Lista de permisos")
     * )
     */
    public function index()
    {
        return response()->json(Permiso::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/permisos/{id}",
     *     summary="Mostrar un permiso por ID",
     *     tags={"Permisos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del permiso",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Permiso encontrado"),
     *     @OA\Response(response=404, description="Permiso no encontrado")
     * )
     */
    public function show($id)
    {
        $permiso = Permiso::find($id);
        if (!$permiso) {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }
        return response()->json($permiso, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/permisos",
     *     summary="Crear un nuevo permiso",
     *     tags={"Permisos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="editar_usuarios")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Permiso creado exitosamente"),
     *     @OA\Response(response=422, description="Errores de validación")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:permisos,nombre',  // Aquí 'permisos' es el nombre correcto de la tabla
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $permiso = Permiso::create($request->all());
        return response()->json($permiso, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/permisos/{id}",
     *     summary="Actualizar un permiso existente",
     *     tags={"Permisos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del permiso",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="ver_reportes")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Permiso actualizado exitosamente"),
     *     @OA\Response(response=404, description="Permiso no encontrado"),
     *     @OA\Response(response=422, description="Errores de validación")
     * )
     */
    public function update(Request $request, $id)
    {
        $permiso = Permiso::find($id);
        if (!$permiso) {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:100|unique:permisos,nombre,' . $id,  // 'permisos' es el nombre correcto de la tabla
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $permiso->update($request->all());
        return response()->json($permiso, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/permisos/{id}",
     *     summary="Eliminar un permiso",
     *     tags={"Permisos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del permiso",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Permiso eliminado correctamente"),
     *     @OA\Response(response=404, description="Permiso no encontrado")
     * )
     */
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
