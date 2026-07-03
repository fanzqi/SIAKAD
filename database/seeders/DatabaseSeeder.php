<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Hapus semua data dengan urutan yang benar (child table dihapus terlebih dahulu)
        DB::table('notification_user')->delete();
        DB::table('notifications')->delete();
        DB::table('jadwal')->delete();
        DB::table('nilai_mahasiswa')->delete();
        DB::table('krs')->delete();
        DB::table('input_nilai')->delete();
        DB::table('jabatan_struktural')->delete();
        DB::table('mahasiswa')->delete();
        DB::table('dosen')->delete();
        DB::table('mata_kuliah')->delete();
        DB::table('ruangs')->delete();
        DB::table('kurikulums')->delete();
        DB::table('program_studi')->delete();
        DB::table('fakultas')->delete();
        DB::table('tahun_akademik')->delete();
        DB::table('users')->delete();

        Schema::enableForeignKeyConstraints();

        $this->call([
            // Data master (tidak memiliki foreign key)
            FakultasSeeder::class,
            ProgramStudiSeeder::class,
            TahunAkademikSeeder::class,
            UserSeeder::class,

            // Data yang bergantung pada master
            DosenSeeder::class,
            KurikulumSeeder::class,
            RuangSeeder::class,

            // Data yang bergantung pada dosen dan prodi
            MataKuliahSeeder::class, // <-- Tambahkan ini

            // Data yang bergantung pada dosen dan mahasiswa
            MahasiswaSeeder::class,

            // Data yang bergantung pada dosen dan mahasiswa
            JabatanStrukturalSeeder::class,
        ]);
    }
}
