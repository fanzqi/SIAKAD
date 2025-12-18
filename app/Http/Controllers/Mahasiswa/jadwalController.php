<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwalkuliah;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::with('tahunAkademik')
    ->where('nim', Auth::user()->username)
    ->firstOrFail();

// Kode grup masih bisa ambil dari semester_aktif atau tahun_akademik->semester_ke
$kodeGrup = DB::table('mata_kuliah')
    ->where('program_studi_id', $mahasiswa->prodi_id)
    ->whereRaw('LEFT(`group`, LENGTH(`group`) - 2) = ?', [$mahasiswa->tahunAkademik->semester_ke])
    ->value('group');

$jadwal = Jadwalkuliah::with([
        'mata_kuliah',
        'mata_kuliah.dosen',
        'ruang'
    ])
    ->where('semester', $mahasiswa->tahunAkademik->semester_ke)
    ->whereHas('mata_kuliah', function ($q) use ($mahasiswa, $kodeGrup) {
        $q->where('program_studi_id', $mahasiswa->prodi_id)
          ->where('group', $kodeGrup);
    })
    ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
    ->orderBy('jam_mulai')
    ->get();

return view('mahasiswa.jadwalkuliah.index', compact('jadwal', 'mahasiswa'));

    }
}