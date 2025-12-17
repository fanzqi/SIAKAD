<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwalkuliah;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // Ambil mahasiswa yang login
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->username)->firstOrFail();
        $semester = $mahasiswa->semester_aktif;
        $grupId = $mahasiswa->grup_id; // gunakan grup_id dari mahasiswa
$jadwal = Jadwalkuliah::with(['mata_kuliah', 'mata_kuliah.dosen', 'ruang'])
    ->where('semester', $semester)
    ->whereHas('mata_kuliah', function($q) use ($mahasiswa) {
        $q->where('group', $mahasiswa->grup_id); // pastikan kolom 'group'
    })
    ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
    ->orderBy('jam_mulai')
    ->get();



        return view('mahasiswa.jadwalkuliah.index', compact('jadwal', 'semester', 'mahasiswa'));
    }
}
