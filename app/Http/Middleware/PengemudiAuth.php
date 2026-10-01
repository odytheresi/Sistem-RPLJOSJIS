<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PengemudiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

    #middleware = pemeriksa sebelum pengguna masuk ke halaman
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('pengemudi')->check()) {
            return redirect()->route('pengemudi.login');
        }
        return $next($request);
    }
}
