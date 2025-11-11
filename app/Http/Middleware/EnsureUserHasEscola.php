<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasEscola
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->escola_id) {
            auth()->logout();
            return redirect('/login')->withErrors([
                'error' => 'Seu usuário não está associado a nenhuma escola.'
            ]);
        }

        return $next($request);
    }
}
