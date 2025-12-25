<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Jadwalkuliah;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalPdfController extends Controller
{
    public function exportAll()
    {
        // Ambil data jadwal beserta relasi
        $jadwal = Jadwalkuliah::with([
                'mata_kuliah.dosen',         // relasi dosen
                'mata_kuliah.program_studi', // relasi program studi
                'ruang'
            ])
            ->orderBy('semester')
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy([
                fn($item) => $item->mata_kuliah?->program_studi?->nama ?? 'LAINNYA',
                fn($item) => $item->semester,
            ]);

        if ($jadwal->isEmpty()) {
            return back()->with('error', 'Data jadwal tidak ditemukan.');
        }

        $pdf = Pdf::loadView('Akademik.jadwalkuliah.pdf', compact('jadwal'))
            ->setPaper('folio', 'portrait');

        return $pdf->download('jadwal_kuliah_semua_prodi_semester.pdf');
    }
}
