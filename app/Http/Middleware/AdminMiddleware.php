<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado y es admin
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'admin') {
            // Si no es admin, redirigir al home de usuarios normales
            return redirect()->route('pages.home')->with('error', 'No tienes permisos de administrador.');
        }

        return $next($request);
    }
}