<?php

namespace App\Http\Controllers\Dekan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Mata_kuliah;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔔 Notifikasi terakhir 5
        $notifications = Notification::orderBy('id', 'desc')->limit(5)->get();

        // ✅ Fakultas sesuai akun login
        $user = auth()->user();
        $fakultasId = $user->dosen->fakultas_id ?? null;

        // 📊 Statistik Card
        $totalMahasiswa = Mahasiswa::where('fakultas_id', $fakultasId)->count();
        $totalDosen     = User::where('role', 'dosen')
                               ->whereHas('dosen', fn($q) => $q->where('fakultas_id', $fakultasId))
                               ->count();
        $totalProdi     = DB::table('program_studi')->where('fakultas_id', $fakultasId)->count();
        $totalMatkul    = Mata_kuliah::where('fakultas_id', $fakultasId)->count();

        // 📈 Sebaran Mahasiswa Per Prodi
        $sebaranProdi = DB::table('program_studi')
            ->leftJoin('mahasiswa', 'program_studi.id', '=', 'mahasiswa.prodi_id')
            ->select(
                'program_studi.nama as prodi',
                DB::raw('COUNT(mahasiswa.id) as jumlah')
            )
            ->where('program_studi.fakultas_id', $fakultasId)
            ->groupBy('program_studi.nama')
            ->get();

        return view('dekan.dashboard.index', compact(
            'notifications',
            'totalMahasiswa',
            'totalDosen',
            'totalProdi',
            'totalMatkul',
            'sebaranProdi'
        ));
    }
}
