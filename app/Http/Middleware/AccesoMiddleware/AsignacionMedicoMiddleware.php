<?php

namespace Ace\Http\Middleware\AccesoMiddleware;

use Closure;
use Laracasts\Flash\Flash;
use Auth;

class AsignacionMedicoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Para que otro usuario diferente a un asistente no puedan acceder a la ruta de asignacion de medico
        if(Auth::user()->perfil_id != 3){

            Flash::warning('No tiene permiso para realizar esta acción.');
            return redirect()->route('panel.user.bienvenido');
        }

        return $next($request);
    }
}
