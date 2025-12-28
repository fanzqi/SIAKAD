<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\mata_kuliah;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
      $user = Auth::user();

      $dosen = Dosen::where('email', $user->email)
                    ->orWhere('nidn', $user->username)
                    ->first();

      $totalMahasiswa = 0;
      $totalMatkul = 0;
      $namaDosen = 'Tidak ditemukan';

      if($dosen) {
          $namaDosen = $dosen->nama;

          // Ambil semua id matakuliah yang diampu dosen ini
          $matkulIds = mata_kuliah::where('dosen_id', $dosen->id)->pluck('id')->toArray();

          // Menghitung jumlah mahasiswa unik yang menempuh setidaknya satu matakuliah yang diampu dosen
          if (!empty($matkulIds)) {
              $totalMahasiswa = DB::table('krs')
                  ->whereIn('mata_kuliah_id', $matkulIds)
                  ->distinct('mahasiswa_id')
                  ->count('mahasiswa_id');
          } else {
              $totalMahasiswa = 0;
          }

          $totalMatkul = count($matkulIds);
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
