<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Jadwalkuliah;
use App\Models\JabatanStruktural;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosen = $user->dosen ?? null;

        // Ambil jabatan Kaprodi aktif (mengutamakan jabatan KAPRODI, bukan sekedar status aktif)
      $jabatanKaprodi = JabatanStruktural::where('dosen_id', $dosen->id)
    ->where('jabatan', 'Kaprodi')
    ->where('status', 'Aktif')
    ->first();

        $prodi = $jabatanKaprodi && $jabatanKaprodi->prodi ? $jabatanKaprodi->prodi : null;

        if (!$prodi) {
            return view('kaprodi.jadwalkuliah.index', [
                'jadwal' => collect(),
                'dosen' => $dosen,
                'message' => 'Anda belum memiliki jabatan Kaprodi aktif.'
            ]);
        }

        // Ambil jadwal untuk prodi diampu kaprodi aktif
        $jadwal = Jadwalkuliah::with(['mata_kuliah', 'ruang'])
            ->where('status', 'didistribusi')
            ->where('program_studi_id', $prodi->id)
            ->get();

        return view('kaprodi.jadwalkuliah.index', compact('jadwal', 'dosen'));
    }
}