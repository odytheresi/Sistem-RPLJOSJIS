<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\login; 

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', 
            'pass'  => 'required', 
        ]);

        // Cek apakah input berupa email atau nama
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nma_user';

        // Cari user di database
        $user = login::where($fieldType, $request->login)->first();

        // Cek apakah user ada dan password teks biasa-nya cocok
        if ($user && $user->pass === $request->pass) {
            
            // Cek status aktif
            if ($user->status !== 'aktif') {
                return back()->withErrors(['login' => 'Akun Anda sudah nonaktif.'])->withInput();
            }

            // SIMPAN SESI MANUAL (Model aman, tidak perlu diubah sama sekali!)
            $request->session()->put('user_id', $user->user_id);
            $request->session()->put('nma_user', $user->nma_user);
            $request->session()->put('id_role', $user->id_role);
            $request->session()->regenerate();

            // BERHASIL -> Arahkan sesuai role
            return match ($user->id_role) {
                1 => redirect('/admin/dashboard'),
                2 => redirect('/operator/dashboard'),
                3 => redirect('/pengemudi/dashboard'),
                default => redirect('/dashboard'),
            };
        }

        // Jika gagal, kembalikan ke form sambil membawa input sebelumnya pakai withInput()
        return back()->withErrors([
            'login' => 'Nama/Email atau kata sandi salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['user_id', 'nma_user', 'id_role']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}