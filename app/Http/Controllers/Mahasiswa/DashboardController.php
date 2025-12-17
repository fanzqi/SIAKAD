<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\mata_kuliah;
use App\Models\Notification;
 use App\Models\Kurikulum;


class DashboardController extends Controller
{

public function index()
{
    $user = Auth::user();

    $mahasiswa = Mahasiswa::with('programStudi')
        ->where('nama', $user->name)
        ->firstOrFail();

    $kurikulumId = $mahasiswa->kurikulum_id;

    // ===============================
    // HITUNG BERDASARKAN TABEL KURIKULUMS
    // ===============================

    $totalMatkul = Kurikulum::where('id', $kurikulumId)->count();

    $totalSks = Kurikulum::where('id', $kurikulumId)->sum('sks');

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
