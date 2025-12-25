<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Dosen;
use App\Models\NilaiMahasiswa;
use App\Models\Mata_kuliah;
use App\Models\Mahasiswa;

class NilaiMahasiswaController extends Controller
{
    // ======================
    // TAMPIL DATA NILAI
    // ======================
    public function index(Request $request)
    {
        // dosen login (login pakai nidn)
        $dosen = Dosen::where('nidn', Auth::user()->username)->firstOrFail();

        // mata kuliah yang diajar dosen
        $mataKuliah = Mata_kuliah::where('dosen_id', $dosen->id)->get();

        $selectedMataKuliah = $request->mata_kuliah_id;

        // nilai mahasiswa sesuai dosen & mk
        $nilaiMahasiswa = NilaiMahasiswa::with(['mahasiswa', 'mata_kuliah'])
            ->where('dosen_id', $dosen->id)
            ->when($selectedMataKuliah, function ($q) use ($selectedMataKuliah) {
                $q->where('mata_kuliah_id', $selectedMataKuliah);
            })
            ->get();

        // mahasiswa sesuai mata kuliah
        $mahasiswa = collect();

        if ($selectedMataKuliah) {
            $mahasiswa = Mahasiswa::whereHas('mataKuliah', function ($q) use ($selectedMataKuliah) {
                $q->where('mata_kuliah.id', $selectedMataKuliah);
            })
            ->orderBy('nama')
            ->get();
        }

        return view('dosen.inputnilai.index', compact(
            'mataKuliah',
            'mahasiswa',
            'nilaiMahasiswa',
            'selectedMataKuliah'
        ));
    }

    // ======================
    // SIMPAN NILAI
    // ======================
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id'   => 'required|exists:mahasiswa,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'kehadiran'      => 'required|numeric|min:0|max:100',
            'tugas'          => 'required|numeric|min:0|max:100',
            'uts'            => 'required|numeric|min:0|max:100',
            'uas'            => 'required|numeric|min:0|max:100',
        ]);

        $dosen = Auth::user()->dosen;

        $nilaiAkhir =
            ($request->kehadiran * 0.10) +
            ($request->tugas * 0.20) +
            ($request->uts * 0.30) +
            ($request->uas * 0.40);

        // Grade & bobot
        if ($nilaiAkhir >= 90) {
            $grade = 'A';  $bobot = 4.00;
        } elseif ($nilaiAkhir >= 80) {
            $grade = 'A-'; $bobot = 3.75;
        } elseif ($nilaiAkhir >= 75) {
            $grade = 'B+'; $bobot = 3.25;
        } elseif ($nilaiAkhir >= 70) {
            $grade = 'B';  $bobot = 3.00;
        } elseif ($nilaiAkhir >= 65) {
            $grade = 'B-'; $bobot = 2.75;
        } elseif ($nilaiAkhir >= 60) {
            $grade = 'C+'; $bobot = 2.25;
        } elseif ($nilaiAkhir >= 55) {
            $grade = 'C';  $bobot = 2.00;
        } elseif ($nilaiAkhir >= 50) {
            $grade = 'C-'; $bobot = 1.75;
        } else {
            $grade = 'D';  $bobot = 1.00;
        }

        NilaiMahasiswa::updateOrCreate(
            [
                'mahasiswa_id'   => $request->mahasiswa_id,
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'dosen_id'       => $dosen->id,
            ],
            [
                'kehadiran'   => $request->kehadiran,
                'tugas'       => $request->tugas,
                'uts'         => $request->uts,
                'uas'         => $request->uas,
                'nilai_akhir' => round($nilaiAkhir, 2),
                'grade'       => $grade,
                'bobot'       => $bobot,
            ]
        );

        return back()->with('success', 'Nilai berhasil disimpan');
    }
}