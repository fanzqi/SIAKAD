<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Jadwalkuliah;
use App\Models\Dosen;
use App\Models\JabatanStruktural;
use Illuminate\Support\Facades\Auth;


class JadwalController extends Controller
{
    public function index()
    {
        // Ambil data dosen yang login
        $dosen = Dosen::where('nidn', Auth::user()->username)->firstOrFail();

        // Ambil id_prodi dari dosen_jabatan (Kaprodi aktif)
        $jabatan = JabatanStruktural::where('dosen_id', $dosen->id)
                    ->where('status', 'Aktif')
                    ->first();

        if (!$jabatan) {
            return view('kaprodi.jadwalkuliah.index', [
                'jadwal' => collect(),
                'dosen' => $dosen,
                'message' => 'Anda belum memiliki jabatan Kaprodi aktif.'
            ]);
        }

        $prodi_id = $jabatan->id_prodi;

        // Ambil jadwal untuk prodi yang bersangkutan
        $jadwal = Jadwalkuliah::with(['mata_kuliah', 'ruang'])
                    ->where('is_published', true)
                    ->where('program_studi_id', $prodi_id)
                    ->get();

        return view('kaprodi.jadwalkuliah.index', compact('jadwal', 'dosen'));
    }
}
