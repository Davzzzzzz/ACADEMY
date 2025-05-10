<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API Foro Laravel"
 * )
 */

/**
 * @OA\Schema(
 *   schema="Usuario",
 *   type="object",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="nombre", type="string", example="Juan Pérez"),
 *   @OA\Property(property="correo", type="string", example="juan@example.com"),
 *   @OA\Property(property="fecha_registro", type="string", format="date", example="2024-01-01"),
 *   @OA\Property(property="id_rol", type="integer", example=2)
 * )
 */
class UsuarioController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:sanctum');
        //$this->middleware('admin')->only(['destroy']);
    }

    /**
     * @OA\Get(
     *   path="/api/usuarios",
     *   tags={"Usuarios"},
     *   summary="Lista todos los usuarios",
     *   @OA\Response(response=200, description="Lista de usuarios")
     * )
     */
    public function index()
    {
        return response()->json(Usuario::all());
    }

    /**
     * @OA\Post(
     *   path="/api/usuarios",
     *   tags={"Usuarios"},
     *   summary="Crear un usuario",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     *       @OA\Property(property="correo", type="string", example="juan@example.com"),
     *       @OA\Property(property="contrasena", type="string", example="password123"),
     *       @OA\Property(property="id_rol", type="integer", example=2)
     *     )
     *   ),
     *   @OA\Response(response=201, description="Usuario creado exitosamente")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuario,correo',
            'contrasena' => 'required|string|min:8',
            'id_rol' => 'required|integer',
        ]);

        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->contrasena = bcrypt($request->contrasena);
        $usuario->fecha_registro = now();
        $usuario->id_rol = $request->id_rol;
        $usuario->save();

        return response()->json($usuario, 201);
    }

    /**
     * @OA\Get(
     *   path="/api/usuarios/{id}",
     *   tags={"Usuarios"},
     *   summary="Obtener un usuario por ID",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Detalles del usuario")
     * )
     */
    public function show($id)
    {
        return response()->json(Usuario::findOrFail($id));
    }

    /**
     * @OA\Put(
     *   path="/api/usuarios/{id}",
     *   tags={"Usuarios"},
     *   summary="Actualizar un usuario",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     *       @OA\Property(property="correo", type="string", example="juan@example.com"),
     *       @OA\Property(property="contrasena", type="string", example="newpassword123"),
     *       @OA\Property(property="id_rol", type="integer", example=2)
     *     )
     *   ),
     *   @OA\Response(response=200, description="Usuario actualizado correctamente")
     * )
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'correo' => 'sometimes|required|email|unique:usuario,correo,' . $usuario->id . ',id',
            'contrasena' => 'sometimes|nullable|string|min:8',
            'id_rol' => 'sometimes|required|integer',
        ]);

        $usuario->nombre = $request->nombre ?? $usuario->nombre;
        $usuario->correo = $request->correo ?? $usuario->correo;
        if ($request->filled('contrasena')) {
            $usuario->contrasena = bcrypt($request->contrasena);
        }
        $usuario->id_rol = $request->id_rol ?? $usuario->id_rol;
        $usuario->save();

        return response()->json($usuario);
    }

     /**
     * @OA\Delete(
     *   path="/api/usuarios/{id}",
     *   tags={"Usuarios"},
     *   summary="Eliminar un usuario",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Usuario eliminado correctamente")
     * )
     */
    public function destroy($id)
{
    // Buscar el usuario por la columna 'id', que es la clave primaria por defecto
    $usuario = Usuario::find($id);

    if (!$usuario) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    // Eliminamos el usuario
    $usuario->delete();

    return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
}

}
