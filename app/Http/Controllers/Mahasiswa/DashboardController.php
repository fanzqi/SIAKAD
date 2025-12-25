<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Kurikulum;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil mahasiswa berdasarkan username (nim)
        $mahasiswa = Mahasiswa::with('prodi')
            ->where('nim', $user->username)  // username di users = nim mahasiswa
            ->first();

        if (!$mahasiswa) {
            abort(404, 'Mahasiswa tidak ditemukan');
        }

        $kurikulumId = $mahasiswa->kurikulum_id;

        // Hitung total mata kuliah dan total SKS di kurikulum
        $totalMatkul = Kurikulum::where('id', $kurikulumId)->count();
        $totalSks = Kurikulum::where('id', $kurikulumId)->sum('sks');

        // Ambil 5 notifikasi terbaru
        $notifications = Notification::latest()
            ->limit(5)
            ->get();

        return view('mahasiswa.dashboard.index', compact(
            'user',
            'mahasiswa',
            'totalMatkul',
            'totalSks',
            'notifications'
        ));
    }
}
