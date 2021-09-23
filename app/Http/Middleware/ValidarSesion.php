<?php

namespace App\Http\Middleware;

use App\Actor;
use App\GestionPermisos;
use App\GestorConexiones;
use Closure;

class ValidarSesion
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
        if(Actor::getActorLogeado()==""){
            return redirect()->route('user.error')->with('datos','Debe ingresar al sistema para administrarlo, no tiene permisos suficientes.');
        }
        
        
        return $next($request);
    }
}
