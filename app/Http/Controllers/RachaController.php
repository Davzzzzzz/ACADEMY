<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Racha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RachaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $rachas = Racha::where('user_id', Auth::id())->get();
        return response()->json($rachas);
    }

    public function show($id)
    {
        $racha = Racha::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$racha) {
            return response()->json(['message' => 'Racha no encontrada'], 404);
        }
        return response()->json($racha);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dias_consecutivos' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $racha = Racha::create([
            'user_id' => Auth::id(),
            'dias_consecutivos' => $request->dias_consecutivos,
        ]);

        return response()->json($racha, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'dias_consecutivos' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $racha = Racha::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$racha) {
            return response()->json(['message' => 'Racha no encontrada'], 404);
        }

        $racha->update($request->all());
        return response()->json($racha);
    }

    public function destroy($id)
    {
        $racha = Racha::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$racha) {
            return response()->json(['message' => 'Racha no encontrada'], 404);
        }

        $racha->delete();
        return response()->json(['message' => 'Racha eliminada correctamente']);
    }
}
