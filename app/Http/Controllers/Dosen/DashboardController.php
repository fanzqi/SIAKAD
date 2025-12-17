<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\mata_kuliah;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
  public function index()
{
    $user = Auth::user();

    // Cek dosen via email atau nidn
    $dosen = Dosen::where('email', $user->email)
                   ->orWhere('nidn', $user->username) // jika login pakai nidn
                   ->first();

    // Jika dosen tidak ditemukan, tetap lempar ke view tapi beri default
    $totalMahasiswa = 0;
    $totalMatkul = 0;
    $namaDosen = 'Tidak ditemukan';

    if($dosen) {
        $namaDosen = $dosen->nama;
        $totalMahasiswa = Mahasiswa::where('prodi_id', $dosen->prodi_id)->count();
        $totalMatkul = mata_kuliah::where('dosen_id', $dosen->id)->count();
    }

    $notifications = Notification::latest()->limit(5)->get();

    return view('dosen.dashboard.index', compact(
        'namaDosen',
        'totalMahasiswa',
        'totalMatkul',
        'notifications'

    ));
}


}
