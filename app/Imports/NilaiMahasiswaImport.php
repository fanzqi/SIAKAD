<?php

namespace App\Imports;

use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Mata_kuliah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NilaiMahasiswaImport implements ToModel, WithHeadingRow
{
    /**
     * Convert each row to a NilaiMahasiswa model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Pastikan ada 'nim' dan 'mata_kuliah'
        if (!Arr::has($row, 'nim') || !Arr::has($row, 'mata_kuliah')) {
            return null;
        }

        // Cari Mahasiswa
        $mahasiswa = Mahasiswa::where('nim', Arr::get($row, 'nim'))->first();
        // Cari Mata Kuliah
        $mataKuliah = Mata_kuliah::where('kode', Arr::get($row, 'mata_kuliah'))->first();
        // Ambil dosen_id dari user login
        $dosen_id = Auth::user()->dosen->id ?? null;

        if (!$mahasiswa || !$mataKuliah || !$dosen_id) {
            return null; // Lewati jika data tidak valid
        }

        // Hitung nilai akhir
        $kehadiran = floatval(Arr::get($row, 'kehadiran', 0));
        $tugas     = floatval(Arr::get($row, 'tugas', 0));
        $uts       = floatval(Arr::get($row, 'uts', 0));
        $uas       = floatval(Arr::get($row, 'uas', 0));

        $nilaiAkhir = ($kehadiran * 0.1) + ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.4);

        // Tentukan grade dan bobot
        if ($nilaiAkhir >= 85) {
            $grade = 'A'; $bobot = 4.00;
        } elseif ($nilaiAkhir >= 75) {
            $grade = 'B'; $bobot = 3.00;
        } elseif ($nilaiAkhir >= 65) {
            $grade = 'C'; $bobot = 2.00;
        } else {
            $grade = 'D'; $bobot = 1.00;
        }

        return new NilaiMahasiswa([
            'mahasiswa_id'   => $mahasiswa->id,
            'dosen_id'       => $dosen_id,
            'mata_kuliah_id' => $mataKuliah->id,
            'kehadiran'      => $kehadiran,
            'tugas'          => $tugas,
            'uts'            => $uts,
            'uas'            => $uas,
            'nilai_akhir'    => $nilaiAkhir,
            'grade'          => $grade,
            'bobot'          => $bobot,
        ]);
    }
}