<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Administrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /* Middleware de seguridad para confirmar que es un administrador el que inicia sesion en la parte de laravel */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->administrador=="no"){
            return redirect(route('welcome'));
        }
        return $next($request);
    }
}
