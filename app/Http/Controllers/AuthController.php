<?php

namespace App\Http\Controllers;

use App\Models\Audit_Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    private function gagal(Request $request, string $pesan, int $status = 422)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $pesan], $status);
        }

        return back()->withErrors(['identifier' => $pesan])->withInput();
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
        ]);

        $user = User::with(['role.hakAkses', 'admin'])
            ->where('identifier', trim($data['identifier']))
            ->first();

        // 1. Akun sedang terkunci
        if ($user && $user->locked_until && now()->lt($user->locked_until)) {
            $sisa = (int) ceil(now()->diffInMinutes($user->locked_until, false));
            Audit_Log::catat('login_gagal', 'Akun terkunci', 'User', (string) $user->id_user, $user->id_user);

            return $this->gagal($request, "Akun terkunci. Coba lagi dalam {$sisa} menit.", 423);
        }

        // 2. Password salah atau user tidak ada
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            if ($user) {
                $user->failed_login++;

                if ($user->failed_login >= config('ev.max_login_gagal')) {
                    $user->locked_until = now()->addMinutes(config('ev.kunci_menit'));
                    $user->failed_login = 0;
                }
                $user->save();
            }

            Audit_Log::catat(
                'login_gagal',
                'Login gagal: ' . $data['identifier'],
                'User',
                $user ? (string) $user->id_user : null,
                $user?->id_user
            );

            return $this->gagal($request, 'Identifier atau password salah.', 401);
        }

        // 3. Akun atau role nonaktif
        if ($user->status !== 'aktif' || $user->role?->status !== 'aktif') {
            Audit_Log::catat('login_gagal', 'Akun atau role nonaktif', 'User', (string) $user->id_user, $user->id_user);

            return $this->gagal($request, 'Akun atau role nonaktif.', 403);
        }

        // 4. Berhasil
        $user->forceFill(['failed_login' => 0, 'locked_until' => null])->save();

        Auth::login($user);
        $request->session()->regenerate();

        Audit_Log::catat('login', null, 'User', (string) $user->id_user, $user->id_user);

        $nmaRole  = $user->role->nma_role;
        $redirect = match ($nmaRole) {
            'admin'    => '/admin/dashboard',
            'operator' => route('operator.dashboard', [], false),
            default    => '/pengemudi/dashboard',
        };

        if (! $request->expectsJson()) {
            return redirect($redirect);
        }

        // Token hanya untuk admin (dipakai admin.js memanggil /api/...)
        $token = null;
        if ($nmaRole === 'admin') {
            $user->tokens()->delete();
            $token = $user->createToken('admin', ['*'], now()->addMinutes(config('ev.timeout_menit')))->plainTextToken;
        }

        return response()->json([
            'token'    => $token,
            'user'     => $user,
            'redirect' => $redirect,
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            Audit_Log::catat('logout', null, 'User', (string) $user->id_user, $user->id_user);
            $user->tokens()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
