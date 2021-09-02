<?php

namespace App\Http\Middleware;

use App\Actor;
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

        return $next($request);
    }
}
