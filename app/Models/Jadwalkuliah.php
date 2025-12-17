<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwalkuliah extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'mata_kuliah_id',
        'ruangs_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'semester',
        'group_kelas',
        'fakultas_id',
        'program_studi_id',
    ];

    // RELASI MATA KULIAH
    public function mata_kuliah()
    {
        return $this->belongsTo(Mata_kuliah::class, 'mata_kuliah_id');
    }

    // RELASI RUANG
    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruangs_id');
    }
    // Menghitung jumlah mahasiswa per program studi
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
    public static function getJumlahMahasiswaPerProdi()
    {
        return \App\Models\Mahasiswa::selectRaw('program_studi_id, COUNT(*) as total')
            ->groupBy('program_studi_id')
            ->pluck('total', 'program_studi_id');
    }
}