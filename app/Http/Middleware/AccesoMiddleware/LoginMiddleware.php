<?php

namespace Ace\Http\Middleware\AccesoMiddleware;

use Closure;
use Laracasts\Flash\Flash;
use Auth;

class LoginMiddleware
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
        //Ver si existe una sesion viva, de lo contrario que lo devuelva a login
        if(!Auth::check()){

            Flash::warning('Debe iniciar sesión antes de ingresar a la aplicación.');
            return redirect()->route('user.login');
        }

        return $next($request);
    }
}
