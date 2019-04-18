<?php

namespace SiAtmo\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CekPosisi
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
        if((!Auth::guest()) && (Auth::user()->idPosisi == 1))
        {
            return $next($request);
        }

    }
    
    
}
