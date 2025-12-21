<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class NilaiMahasiswaController extends Controller
{
    /**
     * READ
     * Tampilkan tabel nilai mahasiswa + NIM & Nama
     */
    public function index()
    {
        $nilaiMahasiswa = NilaiMahasiswa::select(
                'nilai_mahasiswa.id_nilaiMahasiswa',
                'mahasiswa.nim',
                'mahasiswa.nama',
                'nilai_mahasiswa.nilai_angka_absen',
                'nilai_mahasiswa.nilai_angka_tugas',
                'nilai_mahasiswa.nilai_angka_uts',
                'nilai_mahasiswa.nilai_angka_uas',
                'nilai_mahasiswa.nilai_angka_akhir',
                'nilai_mahasiswa.nilai_huruf',
                'nilai_mahasiswa.bobot'
            )
            ->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa', '=', 'mahasiswa.id')
            ->orderBy('nilai_mahasiswa.id_nilaiMahasiswa', 'asc')
            ->get();

        return view('dosen.inputnilaimahasiswa.index', compact('nilaiMahasiswa'));
    }

    /**
     * CREATE (FORM)
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama')->get();

        return view('dosen.inputnilaimahasiswa.create', compact('mahasiswa'));
    }

    /**
     * STORE
     */
    public function store(Request $request)
{
    $request->validate([
        'id_mahasiswa'       => 'required|exists:mahasiswa,id',
        'nilai_angka_absen'  => 'required|numeric|min:0|max:100',
        'nilai_angka_tugas'  => 'required|numeric|min:0|max:100',
        'nilai_angka_uts'    => 'required|numeric|min:0|max:100',
        'nilai_angka_uas'    => 'required|numeric|min:0|max:100',
    ]);

    // nilai akhir
    $nilaiAkhir = (
        $request->nilai_angka_absen +
        $request->nilai_angka_tugas +
        $request->nilai_angka_uts +
        $request->nilai_angka_uas
    ) / 4;

    // Konversi huruf & bobot
    if ($nilaiAkhir >= 90 && $nilaiAkhir <= 100) {
        $nilaiHuruf = 'A';
        $bobot = 4.00;
    } elseif ($nilaiAkhir >= 80 && $nilaiAkhir <= 89) {
        $nilaiHuruf = 'A-';
        $bobot = 3.75;
    } elseif ($nilaiAkhir >= 75 && $nilaiAkhir <= 79) {
        $nilaiHuruf = 'B+';
        $bobot = 3.25;
    } elseif ($nilaiAkhir >= 70 && $nilaiAkhir <= 74) {
        $nilaiHuruf = 'B';
        $bobot = 3.00;
    } elseif ($nilaiAkhir >= 65 && $nilaiAkhir <= 69) {
        $nilaiHuruf = 'B-';
        $bobot = 2.75;
    } elseif ($nilaiAkhir >= 60 && $nilaiAkhir <= 64) {
        $nilaiHuruf = 'C+';
        $bobot = 2.25;
    } elseif ($nilaiAkhir >= 55 && $nilaiAkhir <= 59) {
        $nilaiHuruf = 'C';
        $bobot = 2.00;
    } elseif ($nilaiAkhir >= 50 && $nilaiAkhir <= 54) {
        $nilaiHuruf = 'C-';
        $bobot = 1.75;
    } elseif ($nilaiAkhir >= 40 && $nilaiAkhir <= 49) {
        $nilaiHuruf = 'D';
        $bobot = 1.00;
    } else {
        $nilaiHuruf = 'E';
        $bobot = 0.00;
    }

    NilaiMahasiswa::create([
        'id_mahasiswa'        => $request->id_mahasiswa,
        'nilai_angka_absen'   => $request->nilai_angka_absen,
        'nilai_angka_tugas'   => $request->nilai_angka_tugas,
        'nilai_angka_uts'     => $request->nilai_angka_uts,
        'nilai_angka_uas'     => $request->nilai_angka_uas,
        'nilai_angka_akhir'   => $nilaiAkhir,
        'nilai_huruf'         => $nilaiHuruf,
        'bobot'               => $bobot,
    ]);

    return redirect()->route('inputnilaimahasiswa.index')
        ->with('success', 'Nilai mahasiswa berhasil ditambahkan');
}


    /**
     * EDIT (FORM)
     */
    public function edit($id)
{
    $nilai = NilaiMahasiswa::select(
            'nilai_mahasiswa.*',
            'mahasiswa.nim',
            'mahasiswa.nama'
        )
        ->join('mahasiswa', 'nilai_mahasiswa.id_mahasiswa', '=', 'mahasiswa.id')
        ->where('nilai_mahasiswa.id_nilaiMahasiswa', $id)
        ->firstOrFail();

    return view('dosen.inputnilaimahasiswa.edit', compact('nilai'));
}

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai_angka_absen'  => 'required|numeric|min:0|max:100',
            'nilai_angka_tugas'  => 'required|numeric|min:0|max:100',
            'nilai_angka_uts'    => 'required|numeric|min:0|max:100',
            'nilai_angka_uas'    => 'required|numeric|min:0|max:100',
        ]);

        // Hitung nilai akhir (rata-rata)
        $nilaiAkhir = (
        $request->nilai_angka_absen +
        $request->nilai_angka_tugas +
        $request->nilai_angka_uts +
        $request->nilai_angka_uas
        ) / 4;

        // KONVERSI NILAI HURUF + BOBOT
    if ($nilaiAkhir >= 90 && $nilaiAkhir <= 100) {
        $nilaiHuruf = 'A';
        $bobot = 4.00;
    } elseif ($nilaiAkhir >= 80 && $nilaiAkhir <= 89) {
        $nilaiHuruf = 'A-';
        $bobot = 3.75;
    } elseif ($nilaiAkhir >= 75 && $nilaiAkhir <= 79) {
        $nilaiHuruf = 'B+';
        $bobot = 3.25;
    } elseif ($nilaiAkhir >= 70 && $nilaiAkhir <= 74) {
        $nilaiHuruf = 'B';
        $bobot = 3.00;
    } elseif ($nilaiAkhir >= 65 && $nilaiAkhir <= 69) {
        $nilaiHuruf = 'B-';
        $bobot = 2.75;
    } elseif ($nilaiAkhir >= 60 && $nilaiAkhir <= 64) {
        $nilaiHuruf = 'C+';
        $bobot = 2.25;
    } elseif ($nilaiAkhir >= 55 && $nilaiAkhir <= 59) {
        $nilaiHuruf = 'C';
        $bobot = 2.00;
    } elseif ($nilaiAkhir >= 50 && $nilaiAkhir <= 54) {
        $nilaiHuruf = 'C-';
        $bobot = 1.75;
    } elseif ($nilaiAkhir >= 40 && $nilaiAkhir <= 49) {
        $nilaiHuruf = 'D';
        $bobot = 1.00;
    } else {
        $nilaiHuruf = 'E';
        $bobot = 0.00;
    }

        // UPDATE DATABASE
    $nilai = NilaiMahasiswa::findOrFail($id);
    $nilai->update([
        'nilai_angka_absen' => $request->nilai_angka_absen,
        'nilai_angka_tugas' => $request->nilai_angka_tugas,
        'nilai_angka_uts'   => $request->nilai_angka_uts,
        'nilai_angka_uas'   => $request->nilai_angka_uas,
        'nilai_angka_akhir' => $nilaiAkhir,
        'nilai_huruf'       => $nilaiHuruf,
        'bobot'             => $bobot,
    ]);

    return redirect()->route('inputnilaimahasiswa.index')
        ->with('edit', 'Nilai mahasiswa berhasil diperbarui');
}

}
