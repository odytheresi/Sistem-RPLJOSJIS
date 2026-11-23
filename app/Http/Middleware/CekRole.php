<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role?->nma_role, $roles, true)) {
            abort(403, 'Tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}