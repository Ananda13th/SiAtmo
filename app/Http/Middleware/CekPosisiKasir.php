<?php

namespace SiAtmo\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CekPosisiKasir
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
        if((!Auth::guest()) && (Auth::user()->idPosisi == 3))
        {
            return $next($request);
        }

    }
    
    
}
