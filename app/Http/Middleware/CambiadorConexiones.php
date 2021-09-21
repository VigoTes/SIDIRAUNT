<?php

namespace App\Http\Middleware;

use App\GestorConexiones;
use Closure;

class CambiadorConexiones
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
        //GestorConexiones::cambiarConexionSegunLogeado();
        return $next($request);
    }
}
