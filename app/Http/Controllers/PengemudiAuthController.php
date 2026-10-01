<?php

namespace App\Http\Controllers;

use App\Models\Pengemudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PengemudiAuthController extends Controller
{
    /**
     * Menampilkan halaman registrasi pengemudi.
     */
    public function showRegister()
    {
        return view('pengemudi.register');
    }

    public function showLogin()
    {
        return view('pengemudi.login');
    }

    /**
 * Memproses login pengemudi.
 */
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
        'status' => 'aktif',
    ];

    if (Auth::guard('pengemudi')->attempt($credentials)) {
        $request->session()->regenerate();

        return redirect('/pengemudi/dashboard');
    }

    return back()
        ->withErrors([
            'email' => 'Email atau password salah.',
        ])
        ->withInput($request->only('email'));
}

    /**
 * Logout pengemudi.
 */
public function logout(Request $request)
{
    Auth::guard('pengemudi')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('pengemudi.login');
}

/**
 * Menampilkan profil pengemudi yang sedang login.
 */
public function profile()
{
    $pengemudi = Auth::guard('pengemudi')->user();
    return view('pengemudi.profile', compact('pengemudi'));
}

    /**
     * Memproses registrasi pengemudi.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nma_user' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:pengemudi,email',
            'no_hp' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Pengemudi::create([
            'id_role' => 3,
            'nma_user' => $request->nma_user,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'pass' => Hash::make($request->password),
            'status' => 'aktif',
        ]);

        return redirect('/pengemudi/register')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }
}