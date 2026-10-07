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
        'nma_user' => 'required|string',
        'password' => 'required',
    ]);
    $credentials = [
        'nma_user' => $request->nma_user,
        'password' => $request->password,
        'status' => 'aktif',
    ];
    if (Auth::guard('pengemudi')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('pengemudi.dashboard');
    }
    return back()
        ->withErrors([
            'nma_user' => 'Nama pengemudi atau password salah.',
        ])
        ->withInput($request->only('nma_user'));
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
            'nma_user' => 'required|string|max:100|unique:pengemudi,nma_user',
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

    /**
 * Menampilkan halaman edit profil pengemudi.
 */
public function editProfile()
{
    $pengemudi = Auth::guard('pengemudi')->user();

    return view('pengemudi.edit_profile', compact('pengemudi'));
}

/**
 * Memproses perubahan profil pengemudi.
 */
public function updateProfile(Request $request)
{
    $pengemudi = Auth::guard('pengemudi')->user();

    $request->validate([
        'nma_user' => 'required|string|max:100|unique:pengemudi,nma_user,' . $pengemudi->user_id . ',user_id',
        'email' => 'required|email|max:100|unique:pengemudi,email,' . $pengemudi->user_id . ',user_id',
        'no_hp' => 'required|string|max:20',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $pengemudi->nma_user = $request->nma_user;
    $pengemudi->email = $request->email;
    $pengemudi->no_hp = $request->no_hp;

    // Password hanya diubah jika pengguna mengisinya
    if ($request->filled('password')) {
        $pengemudi->pass = Hash::make($request->password);
    }

    $pengemudi->save();

    return redirect()
        ->route('pengemudi.profile')
        ->with('success', 'Profil berhasil diperbarui.');
    }
}