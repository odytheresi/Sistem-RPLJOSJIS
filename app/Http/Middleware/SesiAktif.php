<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

// NFR-01: sesi berakhir jika tidak ada request selama 15 menit
class SesiAktif
{
    private const BATAS_DETIK = 15 * 60;

    public function handle(Request $request, Closure $next)
    {
        $token = $request->user()?->currentAccessToken();

        if ($token && isset($token->id)) {
            $key  = 'sesi_terakhir_' . $token->id;
            $last = Cache::get($key);

            if ($last && (now()->timestamp - $last) > self::BATAS_DETIK) {
                $token->delete();
                Cache::forget($key);
                abort(401, 'Sesi berakhir karena tidak aktif.');
            }

            Cache::put($key, now()->timestamp, now()->addHours(1));
        }

        return $next($request);
    }
}