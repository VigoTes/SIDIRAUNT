<?php

namespace App\Http\Middleware;

use App\Actor;
use App\GestionPermisos;
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
            return redirect()->route('user.home');
        }

        $permisosCorrectos = GestionPermisos::tienePermisos();
        if(!$permisosCorrectos){
            return redirect()->route('user.error')->with('datos','Usted no tiene permiso para ejecutar esta acción. Verifique con su SuperAdmin la configuración de permisos del sistema.'); //AQUI AÑADIR LA VISTA DE ERROR NO TIENS PERMISOS
        }

        return $next($request);
    }
}
