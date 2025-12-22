<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwalkuliah;
use App\Models\Mahasiswa;
use App\Models\Mata_kuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::with('tahunAkademik')
            ->where('nim', Auth::user()->username)
            ->firstOrFail();

        $daftarGrup = Mata_kuliah::where('program_studi_id', $mahasiswa->prodi_id)
            ->whereRaw('LEFT(`group`, 1) = ?', [$mahasiswa->tahunAkademik->semester_ke])
            ->orderBy('group')
            ->pluck('group')
            ->unique()
            ->values();

        $kodeGrup = $daftarGrup[$mahasiswa->grup_id - 1] ?? null;

        if (!$kodeGrup) {
            abort(404, 'Grup mahasiswa tidak ditemukan');
        }

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
