<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fakultas;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        Fakultas::query()->delete();

        Fakultas::create([
            'nama' => 'Fakultas Sains Teknologi dan Industri',
        ]);

        Fakultas::create([
            'nama' => 'Fakultas Ekonomi dan Bisnis',
        ]);
    }
}
