<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAkademik;

class TahunAkademikSeeder extends Seeder
{
    public function run(): void
    {
        TahunAkademik::query()->delete();

        TahunAkademik::create([
            'tahun_akademik' => '2026/2027',
            'kode_semester' => '20261',
            'semester' => 'Ganjil',
            'semester_ke' => 1,
            'periode_mulai' => '2026-08-01',
            'periode_selesai' => '2026-12-31',
            'status' => 'aktif'
        ]);
    }
}