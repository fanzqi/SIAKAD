<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Jadwalkuliah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class JadwalPdfController extends Controller
{
public function exportAll()
{
    $jadwal = Jadwalkuliah::with(['mata_kuliah', 'ruang'])
        ->whereHas('mata_kuliah', function ($q) {
            $q->whereRaw("
                LEFT(`group`, 1) = CAST(jadwal.semester AS CHAR)
            ");
        })
        ->orderBy('semester')
        ->orderByRaw("
            FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
        ")
        ->orderBy('jam_mulai')
        ->get()
        ->groupBy([
            fn ($item) => $item->mata_kuliah->program_studi ?? 'LAINNYA',
            fn ($item) => $item->semester,
        ]);

    $pdf = Pdf::loadView(
        'Akademik.jadwalkuliah.pdf',
        compact('jadwal')
    )->setPaper('folio', 'portrait');

    return $pdf->download('jadwal_kuliah_semua_prodi_semester.pdf');
}

}