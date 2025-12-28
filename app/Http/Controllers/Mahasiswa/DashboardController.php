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

        $mahasiswa = Mahasiswa::with('prodi')
            ->where('nim', $user->username)
            ->first();

        if (!$mahasiswa) {
            abort(404, 'Mahasiswa tidak ditemukan');
        }


        $listMatkul = Kurikulum::where('id', $mahasiswa->kurikulum_id)->get();

        $totalMatkul = $listMatkul->count(); // ini pasti 1
        $totalSks = $listMatkul->sum('sks');

        $notifications = Notification::latest()
            ->limit(5)
            ->get();

        return view('mahasiswa.dashboard.index', compact(
            'user',
            'mahasiswa',
            'totalMatkul',
            'totalSks',
            'notifications',
            'listMatkul'
        ));
    }
}