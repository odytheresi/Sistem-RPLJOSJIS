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

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            Audit_Log::create([
                'id_user'         => $user?->id_user,
                'aktivitas'       => 'login_gagal',
                'entitas_terkait' => 'User',
                'keterangan'      => 'Login gagal: ' . $data['identifier'],
            ]);

            return response()->json(['message' => 'Identifier atau password salah.'], 401);
        }

        if ($user->status !== 'aktif' || $user->role?->status !== 'aktif') {
            return response()->json(['message' => 'Akun atau role nonaktif.'], 403);
        }

        if (! $user->admin) {
            return response()->json(['message' => 'Akun ini bukan akun admin.'], 403);
        }

        Audit_Log::create([
            'id_user'         => $user->id_user,
            'aktivitas'       => 'login',
            'entitas_terkait' => 'User',
            'id_referensi'    => (string) $user->id_user,
        ]);

        return response()->json([
            'token' => $user->createToken('admin')->plainTextToken,
            'user'  => $user,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Audit_Log::create([
            'id_user'         => $request->user()->id_user,
            'aktivitas'       => 'logout',
            'entitas_terkait' => 'User',
            'id_referensi'    => (string) $request->user()->id_user,
        ]);

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}