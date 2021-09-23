<?php

namespace App\Http\Middleware;

use App\Debug;
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
        //Debug::mensajeSimple('yara:'. env('activarCambioDeUsuarioMYSQL'));
        if(env('activarCambioDeUsuarioMYSQL')=='1')
            GestorConexiones::cambiarConexionSegunLogeado();
        
        return $next($request);
    }
}
