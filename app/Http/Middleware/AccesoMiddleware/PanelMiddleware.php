<?php

namespace Ace\Http\Middleware\AccesoMiddleware;

use Closure;
use Auth;

class PanelMiddleware
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
        //Si ya existe una sesion iniciada, que vayan directamente al panel y no pasen por login
        if(Auth::check()){

            return redirect()->route('panel.user.bienvenido');
        }

        return $next($request);
    }
}
