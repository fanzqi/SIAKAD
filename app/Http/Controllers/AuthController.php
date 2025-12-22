<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fakultas;
use App\Models\ProgramStudi;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        $fakultas = Fakultas::all();
        $prodi = ProgramStudi::all();

       return view('login');
    }

    // Proses login
    public function loginProcess(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'fakultas_id' => 'nullable|exists:fakultas,id', // opsional untuk mahasiswa/dosen
            'prodi_id' => 'nullable|exists:prodi,id',       // opsional untuk mahasiswa/dosen
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Cek fakultas/prodi hanya untuk mahasiswa dan dosen
            if (in_array($user->role, ['mahasiswa', 'dosen'])) {
                if ($request->filled('fakultas_id') && $user->fakultas_id != $request->fakultas_id) {
                    Auth::logout();
                    return back()->withErrors(['username' => 'Fakultas tidak sesuai'])->withInput();
                }

                if ($request->filled('prodi_id') && $user->prodi_id != $request->prodi_id) {
                    Auth::logout();
                    return back()->withErrors(['username' => 'Program Studi tidak sesuai'])->withInput();
                }
            }

            // Redirect otomatis berdasarkan role
            switch ($user->role) {
                case 'dosen':
                    return redirect()->route('dosen.dashboard');
                case 'mahasiswa':
                    return redirect()->route('mahasiswa.dashboard');
                case 'kaprodi':
                    return redirect()->route('kaprodi.dashboard');
                case 'dekan':
                    return redirect()->route('dekan.dashboard');
                case 'warek1':
                    return redirect()->route('warek1.dashboard');
                case 'akademik':
                    return redirect()->route('akademik.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors(['username' => 'Maaf Anda Tidak Terdaftar']);
            }
        }

        // Jika gagal login
        return back()->withErrors(['username' => 'Username atau password salah'])->withInput();
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
