<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
  
    public function index()
    {
        $logins = Login::with('role')->get();
        return view('login.index', compact('logins'));
    }

   
    public function create()
    {
        $roles = Role::all();
        return view('login.create', compact('roles'));
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_role'  => 'required|exists:role,id_role',
            'nma_user' => 'required|string|max:100',
            'no_hp'    => 'required|string|max:20',
            'email'    => 'required|email|max:100|unique:login,email',
            'pass'     => 'required|string|min:6',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        $validated['pass'] = Hash::make($validated['pass']);

        Login::create($validated);

        return redirect()->route('login.index')->with('success', 'User berhasil ditambahkan.');
    }

   
    public function show(Login $login)
    {
        $login->load('role');
        return view('login.show', compact('login'));
    }

    
    public function edit(Login $login)
    {
        $roles = Role::all();
        return view('login.edit', compact('login', 'roles'));
    }


    public function update(Request $request, Login $login)
    {
        $validated = $request->validate([
            'id_role'  => 'required|exists:role,id_role',
            'nma_user' => 'required|string|max:100',
            'no_hp'    => 'required|string|max:20',
            'email'    => 'required|email|max:100|unique:login,email,' . $login->user_id . ',user_id',
            'pass'     => 'nullable|string|min:6',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        if (!empty($validated['pass'])) {
            $validated['pass'] = Hash::make($validated['pass']);
        } else {
            unset($validated['pass']);
        }

        $login->update($validated);

        return redirect()->route('login.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(Login $login)
    {
        $login->delete();

        return redirect()->route('login.index')->with('success', 'User berhasil dihapus.');
    }
}