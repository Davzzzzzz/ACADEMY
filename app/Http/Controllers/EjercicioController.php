<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejercicio;
use App\Models\Leccion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Ejercicios",
 *     description="Operaciones relacionadas con los ejercicios"
 * )
 */
class EjercicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/ejercicios",
     *     summary="Listar todos los ejercicios",
     *     tags={"Ejercicios"},
     *     @OA\Response(response=200, description="Lista de ejercicios")
     * )
     */
    public function index()
    {
        return response()->json(Ejercicio::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/ejercicios/{id}",
     *     summary="Obtener un ejercicio por ID",
     *     tags={"Ejercicios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Ejercicio encontrado"),
     *     @OA\Response(response=404, description="Ejercicio no encontrado")
     * )
     */
    public function show($id)
    {
        $ejercicio = Ejercicio::find($id);
        if (!$ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado'], 404);
        }
        return response()->json($ejercicio, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/ejercicios",
     *     summary="Crear un nuevo ejercicio",
     *     tags={"Ejercicios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pregunta", "respuesta_correcta", "opciones", "id_leccion"},
     *             @OA\Property(property="pregunta", type="string", example="¿Qué significa este gesto?"),
     *             @OA\Property(property="opciones", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="respuesta_correcta", type="string", example="B"),
     *             @OA\Property(property="id_leccion", type="integer", example=1),
     *             @OA\Property(property="id_tipo_pregunta", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Ejercicio creado correctamente"),
     *     @OA\Response(response=422, description="Errores de validación")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pregunta' => 'required|string',
            'opciones' => 'required|array',
            'respuesta_correcta' => 'required|string',
            'id_leccion' => 'required|exists:lecciones,id_leccion',
            'id_tipo_pregunta' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ejercicio = Ejercicio::create([
            'pregunta' => $request->pregunta,
            'opciones' => json_encode($request->opciones),
            'respuesta_correcta' => $request->respuesta_correcta,
            'id_leccion' => $request->id_leccion,
            'id_tipo_pregunta' => $request->id_tipo_pregunta
        ]);

        return response()->json(['message' => 'Ejercicio creado correctamente', 'ejercicio' => $ejercicio], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/ejercicios/{id}",
     *     summary="Actualizar un ejercicio existente",
     *     tags={"Ejercicios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="pregunta", type="string", example="¿Qué se interpreta con este gesto?"),
     *             @OA\Property(property="opciones", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="respuesta_correcta", type="string", example="Sí"),
     *             @OA\Property(property="id_leccion", type="integer", example=1),
     *             @OA\Property(property="id_tipo_pregunta", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Ejercicio actualizado correctamente"),
     *     @OA\Response(response=404, description="Ejercicio no encontrado"),
     *     @OA\Response(response=422, description="Errores de validación")
     * )
     */
    public function update(Request $request, $id)
    {
        $ejercicio = Ejercicio::find($id);

        if (!$ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'pregunta' => 'sometimes|required|string',
            'opciones' => 'sometimes|required|array',
            'respuesta_correcta' => 'sometimes|required|string',
            'id_leccion' => 'sometimes|exists:lecciones,id_leccion',
            'id_tipo_pregunta' => 'sometimes|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('opciones')) {
            $ejercicio->opciones = json_encode($request->opciones);
        }

        $ejercicio->fill($request->except('opciones'));
        $ejercicio->save();

        return response()->json(['message' => 'Ejercicio actualizado correctamente', 'ejercicio' => $ejercicio], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/ejercicios/{id}",
     *     summary="Eliminar un ejercicio",
     *     tags={"Ejercicios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Ejercicio eliminado correctamente"),
     *     @OA\Response(response=404, description="Ejercicio no encontrado")
     * )
     */
    public function destroy($id)
    {
        $ejercicio = Ejercicio::find($id);
        if (!$ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado'], 404);
        }

        $ejercicio->delete();
        return response()->json(['message' => 'Ejercicio eliminado correctamente'], 200);
    }
    public function mostrarEjercicios($id)
    {
    $leccion = Leccion::findOrFail($id);
    $ejercicios = Ejercicio::where('id_leccion', $id)->get();

    foreach ($ejercicios as $ejercicio) {
        // Procesar opciones
        if (is_string($ejercicio->opciones)) {
            $opcionesArray = json_decode($ejercicio->opciones, true);

            foreach ($opcionesArray as &$opcion) {
                if (is_string($opcion)) {
                    $opcion = ['label' => $opcion];
                }

                $archivoOpcion = 'opciones/' . $ejercicio->id_ejercicio . '_' . $opcion['label'] . '.png';

                $opcion['imagen'] = Storage::disk('public')->exists($archivoOpcion)
                    ? asset('storage/' . $archivoOpcion)
                    : null;
            }

            $ejercicio->opciones = $opcionesArray;
        }

        // Imagen de la pregunta
        if (!empty($ejercicio->imagen_pregunta)) {
            $ejercicio->imagen = asset($ejercicio->imagen_pregunta);
        } else {
            $ejercicio->imagen = null;
        }
    }

    return view('ejercicios.index', compact('leccion', 'ejercicios'));
}}



