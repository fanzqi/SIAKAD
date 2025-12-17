<?php

namespace App\Http\Controllers\Warek1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class DashboardController extends Controller
{
  public function index()
{
    return view('warek1.dashboard.index', [
        'totalDosen'     => \App\Models\User::where('role', 'dosen')->count(),
        'totalMahasiswa' => \App\Models\Mahasiswa::count(),
        'totalMatkul'    => \App\Models\mata_kuliah::count(),
        'semesterAktif'  => \App\Models\TahunAkademik::orderByDesc('id')->value('tahun_akademik') ?? '-',
    ]);
}

}