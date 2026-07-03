<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kurikulum;

class KurikulumSeeder extends Seeder
{
    public function run(): void
    {
        Kurikulum::query()->delete();

        Kurikulum::create([
            'tahun_akademik_id' => 1,
            'kode_mk' => 'RSTI101',
            'nama_mk' => 'Algoritma dan Pemrograman',
            'sks' => 3,
            'wajib_pilihan' => 'Wajib',
            'prasyarat' => null,
            'status' => 'Aktif',
        ]);

        Kurikulum::create([
            'tahun_akademik_id' => 1,
            'kode_mk' => 'RSTI102',
            'nama_mk' => 'Basis Data',
            'sks' => 3,
            'wajib_pilihan' => 'Wajib',
            'prasyarat' => 'RSTI101',
            'status' => 'Aktif',
        ]);

        Kurikulum::create([
            'tahun_akademik_id' => 1,
            'kode_mk' => 'RSTI103',
            'nama_mk' => 'Pemrograman Web',
            'sks' => 3,
            'wajib_pilihan' => 'Wajib',
            'prasyarat' => 'RSTI101',
            'status' => 'Aktif',
        ]);
    }
}
