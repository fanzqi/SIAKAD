<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JabatanStruktural;
use App\Models\Dosen;

class JabatanStrukturalSeeder extends Seeder
{
    public function run(): void
    {
        JabatanStruktural::query()->delete();

        // Ambil semua dosen berdasarkan nidn
        $dosenAhmad = Dosen::where('nidn', '0011223344')->first(); // Dr. Ahmad Fauzi
        $dosenSiti = Dosen::where('nidn', '0099887766')->first(); // Dr. Siti Aminah
        $dosenBudi = Dosen::where('nidn', '0033557799')->first(); // Dr. Budi Santoso
        $dosenDewi = Dosen::where('nidn', '0066884422')->first(); // Dr. Dewi Lestari
        $dosenHari = Dosen::where('nidn', '0077889933')->first(); // Prof. Dr. Ir. Hari Widodo
        $dosenRina = Dosen::where('nidn', '0055661133')->first(); // Dr. Ir. Rina Susanti

        $jabatanData = [];

        // === FAKULTAS SAINS TEKNOLOGI DAN INDUSTRI (fakultas_id = 1) ===

        // Kaprodi Sistem dan Teknologi Informasi (prodi_id = 1)
        if ($dosenAhmad) {
            $jabatanData[] = [
                'dosen_id' => $dosenAhmad->id,
                'jabatan' => 'Kaprodi Sistem dan Teknologi Informasi',
                'unit' => 'Prodi',
                'mulai_jabatan' => '2026-08-01',
                'selesai_jabatan' => null,
                'status' => 'Aktif',
            ];
        }

        // Kaprodi Rekayasa Perangkat Lunak (prodi_id = 2)
        if ($dosenSiti) {
            $jabatanData[] = [
                'dosen_id' => $dosenSiti->id,
                'jabatan' => 'Kaprodi Rekayasa Perangkat Lunak',
                'unit' => 'Prodi',
                'mulai_jabatan' => '2026-08-01',
                'selesai_jabatan' => null,
                'status' => 'Aktif',
            ];
        }

        // Dekan Fakultas Sains Teknologi dan Industri
        if ($dosenHari) {
            $jabatanData[] = [
                'dosen_id' => $dosenHari->id,
                'jabatan' => 'Dekan Fakultas Sains Teknologi dan Industri',
                'unit' => 'Fakultas',
                'mulai_jabatan' => '2026-08-01',
                'selesai_jabatan' => null,
                'status' => 'Aktif',
            ];
        }

        // === FAKULTAS EKONOMI DAN BISNIS (fakultas_id = 2) ===

        // Kaprodi Manajemen (prodi_id = 3)
        if ($dosenBudi) {
            $jabatanData[] = [
                'dosen_id' => $dosenBudi->id,
                'jabatan' => 'Kaprodi Manajemen',
                'unit' => 'Prodi',
                'mulai_jabatan' => '2026-08-01',
                'selesai_jabatan' => null,
                'status' => 'Aktif',
            ];
        }

        // Kaprodi Akuntansi (prodi_id = 4)
        if ($dosenDewi) {
            $jabatanData[] = [
                'dosen_id' => $dosenDewi->id,
                'jabatan' => 'Kaprodi Akuntansi',
                'unit' => 'Prodi',
                'mulai_jabatan' => '2026-08-01',
                'selesai_jabatan' => null,
                'status' => 'Aktif',
            ];
        }

        // Dekan Fakultas Ekonomi dan Bisnis
        if ($dosenRina) {
            $jabatanData[] = [
                'dosen_id' => $dosenRina->id,
                'jabatan' => 'Dekan Fakultas Ekonomi dan Bisnis',
                'unit' => 'Fakultas',
                'mulai_jabatan' => '2026-08-01',
                'selesai_jabatan' => null,
                'status' => 'Aktif',
            ];
        }

        // === REKTORAT ===

        // Warek I (Wakil Rektor Bidang Akademik)
        if ($dosenHari) {
            $jabatanData[] = [
                'dosen_id' => $dosenHari->id,
                'jabatan' => 'Warek I Bidang Akademik',
                'unit' => 'Rektorat',
                'mulai_jabatan' => '2026-08-01',
                'selesai_jabatan' => null,
                'status' => 'Aktif',
            ];
        }

        // Kepala Bagian Akademik
        if ($dosenRina) {
            $jabatanData[] = [
                'dosen_id' => $dosenRina->id,
                'jabatan' => 'Kepala Bagian Akademik',
                'unit' => 'Rektorat',
                'mulai_jabatan' => '2026-08-01',
                'selesai_jabatan' => null,
                'status' => 'Aktif',
            ];
        }

        // Insert semua data
        foreach ($jabatanData as $data) {
            if ($data['dosen_id'] !== null) {
                JabatanStruktural::create($data);
            }
        }
    }
}