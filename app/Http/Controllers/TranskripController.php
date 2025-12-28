<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class TranskripController extends Controller
{
    public function show($id)
    {
        $mahasiswa = Mahasiswa::with('nilaiMahasiswa.mata_kuliah')->findOrFail($id);
        $nilai = $mahasiswa->nilaiMahasiswa;
        $totalBobot = 0;
        $totalSks = 0;
        foreach($nilai as $item) {
            $totalSks += $item->mata_kuliah->sks ?? 0;
            $totalBobot += ($item->bobot ?? 0) * ($item->mata_kuliah->sks ?? 0);
        }
        $ipk = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0;
        return view('mahasiswa.transkrip', compact('mahasiswa', 'nilai', 'ipk'));
    }
}