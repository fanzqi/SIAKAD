<?php

namespace App\Http\Controllers\Dekan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\mata_kuliah;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔔 Notifikasi
        $notifications = Notification::orderBy('id', 'desc')->limit(5)->get();

        // 📊 CARD STATISTIK
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen     = User::where('role', 'dosen')->count();
        $totalProdi     = DB::table('program_studi')->count();
        $totalMatkul    = mata_kuliah::count();

        // 📈 SEBARAN MAHASISWA PER FAKULTAS
        $sebaranFakultas = DB::table('fakultas')
            ->leftJoin('program_studi', 'fakultas.id', '=', 'program_studi.fakultas_id')
            ->leftJoin('mahasiswa', 'program_studi.id', '=', 'mahasiswa.prodi_id')
            ->select(
                'fakultas.nama as fakultas',
                DB::raw('COUNT(mahasiswa.id) as jumlah')
            )
            ->groupBy('fakultas.nama')
            ->get();

        return view('dekan.dashboard.index', compact(
            'notifications',
            'totalMahasiswa',
            'totalDosen',
            'totalProdi',
            'totalMatkul',
            'sebaranFakultas'
        ));
    }
}