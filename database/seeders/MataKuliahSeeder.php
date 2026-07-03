<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mata_kuliah; // Perhatikan ini: Mata_kuliah (dengan underscore)
use App\Models\Dosen;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        Mata_kuliah::query()->delete(); // Perhatikan ini: Mata_kuliah

        // Ambil dosen berdasarkan nidn
        $dosenAhmad = Dosen::where('nidn', '0011223344')->first();
        $dosenSiti = Dosen::where('nidn', '0099887766')->first();
        $dosenBudi = Dosen::where('nidn', '0033557799')->first();
        $dosenDewi = Dosen::where('nidn', '0066884422')->first();

        // === MATA KULIAH FAKULTAS SAINS TEKNOLOGI DAN INDUSTRI (fakultas_id = 1) ===

        // Prodi Sistem dan Teknologi Informasi (prodi_id = 1)
        $mkFSTI_STI = [
            [
                'kode' => 'RSTI101',
                'nama_mata_kuliah' => 'Algoritma dan Pemrograman',
                'sks' => 3,
                'dosen_id' => $dosenAhmad ? $dosenAhmad->id : null,
                'fakultas_id' => 1,
                'program_studi_id' => 1,
                'semester' => 1,
                'group' => 'A'
            ],
            [
                'kode' => 'RSTI102',
                'nama_mata_kuliah' => 'Basis Data',
                'sks' => 3,
                'dosen_id' => $dosenAhmad ? $dosenAhmad->id : null,
                'fakultas_id' => 1,
                'program_studi_id' => 1,
                'semester' => 2,
                'group' => 'A'
            ],
            [
                'kode' => 'RSTI103',
                'nama_mata_kuliah' => 'Pemrograman Web',
                'sks' => 3,
                'dosen_id' => $dosenAhmad ? $dosenAhmad->id : null,
                'fakultas_id' => 1,
                'program_studi_id' => 1,
                'semester' => 3,
                'group' => 'A'
            ],
            [
                'kode' => 'RSTI104',
                'nama_mata_kuliah' => 'Jaringan Komputer',
                'sks' => 3,
                'dosen_id' => $dosenAhmad ? $dosenAhmad->id : null,
                'fakultas_id' => 1,
                'program_studi_id' => 1,
                'semester' => 4,
                'group' => 'A'
            ],
        ];

        // Prodi Rekayasa Perangkat Lunak (prodi_id = 2)
        $mkFSTI_RPL = [
            [
                'kode' => 'RPL201',
                'nama_mata_kuliah' => 'Pemrograman Berorientasi Objek',
                'sks' => 3,
                'dosen_id' => $dosenSiti ? $dosenSiti->id : null,
                'fakultas_id' => 1,
                'program_studi_id' => 2,
                'semester' => 1,
                'group' => 'A'
            ],
            [
                'kode' => 'RPL202',
                'nama_mata_kuliah' => 'Rekayasa Perangkat Lunak',
                'sks' => 3,
                'dosen_id' => $dosenSiti ? $dosenSiti->id : null,
                'fakultas_id' => 1,
                'program_studi_id' => 2,
                'semester' => 2,
                'group' => 'A'
            ],
            [
                'kode' => 'RPL203',
                'nama_mata_kuliah' => 'Manajemen Proyek Perangkat Lunak',
                'sks' => 3,
                'dosen_id' => $dosenSiti ? $dosenSiti->id : null,
                'fakultas_id' => 1,
                'program_studi_id' => 2,
                'semester' => 3,
                'group' => 'A'
            ],
            [
                'kode' => 'RPL204',
                'nama_mata_kuliah' => 'Pengujian Perangkat Lunak',
                'sks' => 3,
                'dosen_id' => $dosenSiti ? $dosenSiti->id : null,
                'fakultas_id' => 1,
                'program_studi_id' => 2,
                'semester' => 4,
                'group' => 'A'
            ],
        ];

        // === MATA KULIAH FAKULTAS EKONOMI DAN BISNIS (fakultas_id = 2) ===

        // Prodi Manajemen (prodi_id = 3)
        $mkFEB_MAN = [
            [
                'kode' => 'MAN301',
                'nama_mata_kuliah' => 'Pengantar Manajemen',
                'sks' => 3,
                'dosen_id' => $dosenBudi ? $dosenBudi->id : null,
                'fakultas_id' => 2,
                'program_studi_id' => 3,
                'semester' => 1,
                'group' => 'A'
            ],
            [
                'kode' => 'MAN302',
                'nama_mata_kuliah' => 'Manajemen Sumber Daya Manusia',
                'sks' => 3,
                'dosen_id' => $dosenBudi ? $dosenBudi->id : null,
                'fakultas_id' => 2,
                'program_studi_id' => 3,
                'semester' => 2,
                'group' => 'A'
            ],
            [
                'kode' => 'MAN303',
                'nama_mata_kuliah' => 'Manajemen Pemasaran',
                'sks' => 3,
                'dosen_id' => $dosenBudi ? $dosenBudi->id : null,
                'fakultas_id' => 2,
                'program_studi_id' => 3,
                'semester' => 3,
                'group' => 'A'
            ],
            [
                'kode' => 'MAN304',
                'nama_mata_kuliah' => 'Manajemen Keuangan',
                'sks' => 3,
                'dosen_id' => $dosenBudi ? $dosenBudi->id : null,
                'fakultas_id' => 2,
                'program_studi_id' => 3,
                'semester' => 4,
                'group' => 'A'
            ],
        ];

        // Prodi Akuntansi (prodi_id = 4)
        $mkFEB_AKT = [
            [
                'kode' => 'AKT401',
                'nama_mata_kuliah' => 'Pengantar Akuntansi',
                'sks' => 3,
                'dosen_id' => $dosenDewi ? $dosenDewi->id : null,
                'fakultas_id' => 2,
                'program_studi_id' => 4,
                'semester' => 1,
                'group' => 'A'
            ],
            [
                'kode' => 'AKT402',
                'nama_mata_kuliah' => 'Akuntansi Keuangan',
                'sks' => 3,
                'dosen_id' => $dosenDewi ? $dosenDewi->id : null,
                'fakultas_id' => 2,
                'program_studi_id' => 4,
                'semester' => 2,
                'group' => 'A'
            ],
            [
                'kode' => 'AKT403',
                'nama_mata_kuliah' => 'Akuntansi Manajemen',
                'sks' => 3,
                'dosen_id' => $dosenDewi ? $dosenDewi->id : null,
                'fakultas_id' => 2,
                'program_studi_id' => 4,
                'semester' => 3,
                'group' => 'A'
            ],
            [
                'kode' => 'AKT404',
                'nama_mata_kuliah' => 'Auditing',
                'sks' => 3,
                'dosen_id' => $dosenDewi ? $dosenDewi->id : null,
                'fakultas_id' => 2,
                'program_studi_id' => 4,
                'semester' => 4,
                'group' => 'A'
            ],
        ];

        // Gabungkan semua mata kuliah
        $allMataKuliah = array_merge($mkFSTI_STI, $mkFSTI_RPL, $mkFEB_MAN, $mkFEB_AKT);

        // Insert semua data
        foreach ($allMataKuliah as $mk) {
            // Hanya insert jika dosen_id tidak null
            if ($mk['dosen_id'] !== null) {
                Mata_kuliah::create($mk); // Perhatikan ini: Mata_kuliah
            }
        }
    }
}
