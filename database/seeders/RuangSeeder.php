<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruang;

class RuangSeeder extends Seeder
{
    public function run(): void
    {
        Ruang::query()->delete();

        $ruangan = [
            ['nama_ruang' => 'A2.1', 'kapasitas' => 40, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A2.2', 'kapasitas' => 40, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A2.3', 'kapasitas' => 40, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A2.4', 'kapasitas' => 40, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A2.5', 'kapasitas' => 40, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A2.6', 'kapasitas' => 40, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.1', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.2', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.3', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.4', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.5', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.6', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.7', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.8', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.9', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
            ['nama_ruang' => 'A3.10', 'kapasitas' => 45, 'jam_mulai' => '07:30:00', 'jam_selesai' => '16:30:00'],
        ];

        foreach ($ruangan as $ruang) {
            Ruang::create($ruang);
        }
    }
}