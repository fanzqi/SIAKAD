<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginProcess(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Coba login dengan field username
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $role = strtolower(Auth::user()->role);

            return match ($role) {
                'akademik'   => redirect()->route('akademik.dashboard'),
                'warek1' => redirect()->route('warek1.dashboard'),
                'dekan'      => redirect()->route('dekan.dashboard'),
                'kaprodi'    => redirect()->route('kaprodi.dashboard'),
                'dosen'      => redirect()->route('dosen.dashboard'),
                'mahasiswa'  => redirect()->route('mahasiswa.dashboard'),
                default      => redirect()->route('dashboard'),
            };
        }

        // Jika gagal login
        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
