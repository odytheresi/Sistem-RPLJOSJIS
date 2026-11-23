<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Audit_Log;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
        ]);

        $user = User::with(['role.hakAkses', 'admin'])
            ->where('identifier', $data['identifier'])
            ->first();

        // 1. Akun sedang terkunci
        if ($user && $user->locked_until && now()->lt($user->locked_until)) {
            $sisa = (int) ceil(now()->diffInMinutes($user->locked_until, false));
            Audit_Log::catat('login_gagal', 'Akun terkunci', 'User', (string) $user->id_user, $user->id_user);

            return response()->json([
                'message' => "Akun terkunci. Coba lagi dalam {$sisa} menit.",
            ], 423);
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

            return response()->json(['message' => 'Identifier atau password salah.'], 401);
        }

        // 3. Akun/role nonaktif atau bukan admin
        if ($user->status !== 'aktif' || $user->role?->status !== 'aktif') {
            Audit_Log::catat('login_gagal', 'Akun atau role nonaktif', 'User', (string) $user->id_user, $user->id_user);
            return response()->json(['message' => 'Akun atau role nonaktif.'], 403);
        }

        if (! $user->admin) {
            Audit_Log::catat('login_gagal', 'Bukan akun admin', 'User', (string) $user->id_user, $user->id_user);
            return response()->json(['message' => 'Akun ini bukan akun admin.'], 403);
        }

        // 4. Berhasil
        $user->forceFill(['failed_login' => 0, 'locked_until' => null])->save();
        $user->tokens()->delete(); // hapus token lama

        Audit_Log::catat('login', null, 'User', (string) $user->id_user, $user->id_user);

        return response()->json([
            'token' => $user->createToken('admin', ['*'], now()->addMinutes(config('ev.timeout_menit')))->plainTextToken,
            'user'  => $user,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Audit_Log::catat('logout', null, 'User', (string) $request->user()->id_user);

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}