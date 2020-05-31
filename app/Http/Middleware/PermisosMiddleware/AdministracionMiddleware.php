<?php

namespace Ace\Http\Middleware\PermisosMiddleware;

use Closure;
use Laracasts\Flash\Flash;
use Auth;

class AdministracionMiddleware
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
        //crear un array con los PERMISOS del usuario logueado actualmente
        $permisos = array();
        for($i=0; $i < count(Auth::user()->permisos); $i++){
            array_push($permisos, Auth::user()->permisos[$i]->id);
        }

        if(!in_array(7, $permisos)){

            Flash::warning('No tiene permisos para ingresar a hacer gestiones administrativas.');
            return redirect()->route('panel.user.bienvenido');
        }

        return $next($request);
    }
}
