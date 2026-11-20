<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();
        if (!$user || $user->tipo !== 'admin') {
            abort(403, 'Acesso restrito a administradores.');
        }

        return $next($request);
    }
}
