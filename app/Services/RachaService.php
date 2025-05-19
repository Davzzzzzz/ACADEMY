<?php

namespace App\Services;

use App\Models\Racha;
use App\Models\Usuario;
use Carbon\Carbon;

class RachaService
{
    public function actualizarRacha(Usuario $usuario)
    {
        $hoy = Carbon::today();
        $ayer = Carbon::yesterday();

        $racha = $usuario->racha;

        if ($racha) {
            if ($racha->ultima_fecha === $hoy->toDateString()) {
                return; // Ya se registró hoy
            }

            if ($racha->ultima_fecha === $ayer->toDateString()) {
                $racha->dias_consecutivos += 1;
            } else {
                $racha->dias_consecutivos = 1;
            }

            $racha->ultima_fecha = $hoy;
            $racha->save();
        } else {
            Racha::create([
                'id_usuario' => $usuario->id,
                'dias_consecutivos' => 1,
                'ultima_fecha' => $hoy,
            ]);
        }
    }
}
