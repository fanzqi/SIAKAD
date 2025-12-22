<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\NilaiMahasiswa;
use App\Models\Mata_kuliah;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\NilaiMahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class NilaiMahasiswaController extends Controller
{
    public function index()
    {
        $dosen = Dosen::where('nidn', Auth::user()->username)->firstOrFail();
        $mataKuliah = Mata_kuliah::where('dosen_id', $dosen->id)->get();
        $mataKuliahIds = $mataKuliah->pluck('id');

        $nilaiMahasiswa = NilaiMahasiswa::with('mahasiswa', 'mata_kuliah')
            ->where('dosen_id', $dosen->id)
            ->whereIn('mata_kuliah_id', $mataKuliahIds)
            ->get();

        $mahasiswa = Mahasiswa::where('prodi_id', $dosen->prodi_id)
            ->orderBy('nama')
            ->get();

        return view('dosen.inputnilai.index', compact('nilaiMahasiswa', 'mahasiswa', 'mataKuliah'));
    }

    // Import Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new NilaiMahasiswaImport, $request->file('file'));

        return redirect()->back()->with('success', 'Nilai mahasiswa berhasil diimpor!');
    }

    // Input manual
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'kehadiran' => 'required|numeric|min:0|max:100',
            'tugas' => 'required|numeric|min:0|max:100',
            'uts' => 'required|numeric|min:0|max:100',
            'uas' => 'required|numeric|min:0|max:100',
        ]);

        $dosen_id = Auth::user()->dosen->id;

        $nilaiAkhir = ($request->kehadiran * 0.1) +
                      ($request->tugas * 0.2) +
                      ($request->uts * 0.3) +
                      ($request->uas * 0.4);

        if ($nilaiAkhir >= 85) {
            $grade = 'A'; $bobot = 4.00;
        } elseif ($nilaiAkhir >= 75) {
            $grade = 'B'; $bobot = 3.00;
        } elseif ($nilaiAkhir >= 65) {
            $grade = 'C'; $bobot = 2.00;
        } else {
            $grade = 'D'; $bobot = 1.00;
        }

        NilaiMahasiswa::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'dosen_id' => $dosen_id,
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'kehadiran' => $request->kehadiran,
            'tugas' => $request->tugas,
            'uts' => $request->uts,
            'uas' => $request->uas,
            'nilai_akhir' => $nilaiAkhir,
            'grade' => $grade,
            'bobot' => $bobot,
        ]);

        return back()->with('success', 'Nilai mahasiswa berhasil ditambahkan!');
    }

    // Update nilai
    public function update(Request $request, $id)
    {
        $request->validate([
            'kehadiran' => 'required|numeric|min:0|max:100',
            'tugas' => 'required|numeric|min:0|max:100',
            'uts' => 'required|numeric|min:0|max:100',
            'uas' => 'required|numeric|min:0|max:100',
        ]);

        $nilai = NilaiMahasiswa::findOrFail($id);

        $nilaiAkhir = ($request->kehadiran * 0.1) +
                      ($request->tugas * 0.2) +
                      ($request->uts * 0.3) +
                      ($request->uas * 0.4);

        if ($nilaiAkhir >= 85) {
            $grade = 'A'; $bobot = 4.00;
        } elseif ($nilaiAkhir >= 75) {
            $grade = 'B'; $bobot = 3.00;
        } elseif ($nilaiAkhir >= 65) {
            $grade = 'C'; $bobot = 2.00;
        } else {
            $grade = 'D'; $bobot = 1.00;
        }

        $nilai->update([
            'kehadiran' => $request->kehadiran,
            'tugas' => $request->tugas,
            'uts' => $request->uts,
            'uas' => $request->uas,
            'nilai_akhir' => $nilaiAkhir,
            'grade' => $grade,
            'bobot' => $bobot,
        ]);

        return back()->with('success', 'Nilai mahasiswa berhasil diperbarui!');
    }
}