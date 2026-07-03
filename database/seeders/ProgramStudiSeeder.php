<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        ProgramStudi::query()->delete();

        // Prodi untuk Fakultas Sains Teknologi dan Industri (fakultas_id = 1)
        ProgramStudi::create([
            'fakultas_id' => 1,
            'nama' => 'Sistem dan Teknologi Informasi',
        ]);

        ProgramStudi::create([
            'fakultas_id' => 1,
            'nama' => 'Rekayasa Perangkat Lunak',
        ]);

        // Prodi untuk Fakultas Ekonomi dan Bisnis (fakultas_id = 2)
        ProgramStudi::create([
            'fakultas_id' => 2,
            'nama' => 'Manajemen',
        ]);

        ProgramStudi::create([
            'fakultas_id' => 2,
            'nama' => 'Akuntansi',
        ]);
    }
}
