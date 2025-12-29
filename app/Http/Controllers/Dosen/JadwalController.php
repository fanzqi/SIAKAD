<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Jadwalkuliah;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $dosen = Dosen::where('nidn', Auth::user()->username)
            ->firstOrFail();

        $jadwal = Jadwalkuliah::with(['mata_kuliah', 'ruang'])
    ->where('status', 'didistribusi') // GANTI INI!
    ->whereHas('mata_kuliah', function ($q) use ($dosen) {
        $q->where('dosen_id', $dosen->id);
    })
    ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
    ->orderBy('jam_mulai')
    ->get();

        return view('dosen.jadwalkuliah.index', compact('jadwal', 'dosen'));
    }
}