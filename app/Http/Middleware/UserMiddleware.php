<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'user') {
            return $next($request);
        }

        return back()->with('error', 'No tienes permiso para acceder a esta página.');

    }
}
