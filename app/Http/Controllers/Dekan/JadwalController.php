<?php

namespace App\Http\Controllers\Dekan;

use App\Http\Controllers\Controller;
use App\Models\Jadwalkuliah;
use App\Models\Dosen;
use App\Models\JabatanStruktural;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        // Ambil dosen yang login
        $dosen = Dosen::where('nidn', Auth::user()->username)->firstOrFail();

        // Ambil jabatan Dekan aktif
        $jabatan = JabatanStruktural::where('dosen_id', $dosen->id)
                    ->where('status', 'Aktif')
                    ->first();

        if (!$jabatan) {
            return view('dekan.jadwalkuliah.index', [
                'dosen' => $dosen,
                'program_studi' => collect(),
                'jadwalPerProdi' => collect(),
                'message' => 'Anda belum memiliki jabatan Dekan aktif.'
            ]);
        }

        $fakultas_id = $jabatan->id_fakultas;

        // Ambil semua program studi di fakultas
        $program_studi = ProgramStudi::where('fakultas_id', $fakultas_id)->get();

        // Ambil semua jadwal fakultas ini
       $jadwal = Jadwalkuliah::with(['mata_kuliah', 'dosen', 'ruang'])
    ->where('status', 'didistribusi')
    ->where('fakultas_id', $fakultas_id)
    ->get();
        // Buat array jadwal per prodi
        $jadwalPerProdi = [];
        foreach ($program_studi as $prodi) {
            $jadwalPerProdi[$prodi->id] = $jadwal->where('program_studi_id', $prodi->id);
        }

        return view('dekan.jadwalkuliah.index', compact('dosen', 'program_studi', 'jadwalPerProdi'));
    }
}
