<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EsAdministrador
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->id_rol == 1) { // Asumiendo que el rol 1 es administrador
            return $next($request);
        }

        abort(403, 'Acceso denegado');
    }
}
