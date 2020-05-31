<?php

namespace Ace\Http\Middleware\AccesoMiddleware;

use Closure;
use Laracasts\Flash\Flash;
use Auth;
use Session;

class SinAsignarMedicoMiddleware
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
        //Si es un asistente, y no tiene aun asignado ningun medico, que no puedan hacer nada...
        if(Auth::user()->perfil_id == 3){

            if(Session::get('medicoActual') == null){
                Flash::warning('Antes de continuar, debe elegir un médico con el cual trabajar.');
                return redirect()->route('panel.user.bienvenido');
            }
        }

        return $next($request);
    }
}