<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Roles",
 *     description="Operaciones relacionadas con roles"
 * )
 */
class RolController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Listar todos los roles",
     *     tags={"Roles"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de roles"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Rol::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/{id}",
     *     summary="Obtener un rol por ID",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Rol encontrado"),
     *     @OA\Response(response=404, description="Rol no encontrado")
     * )
     */
    public function show($id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }
        return response()->json($rol, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Crear un nuevo rol",
     *     tags={"Roles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", maxLength=50)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Rol creado"),
     *     @OA\Response(response=400, description="Error de validación")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $rol = Rol::create($request->all());
        return response()->json($rol, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/{id}",
     *     summary="Actualizar un rol existente",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", maxLength=50)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Rol actualizado"),
     *     @OA\Response(response=400, description="Error de validación"),
     *     @OA\Response(response=404, description="Rol no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $rol->update($request->all());
        return response()->json($rol, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/{id}",
     *     summary="Eliminar un rol",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Rol eliminado"),
     *     @OA\Response(response=404, description="Rol no encontrado")
     * )
     */
    public function destroy($id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $rol->delete();
        return response()->json(['message' => 'Rol eliminado'], 200);
    }
}
