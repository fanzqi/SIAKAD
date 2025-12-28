<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    public function nilaiMahasiswa()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'mahasiswa_id');
    }

    public function mataKuliah()
    {
        return $this->belongsToMany(
            Mata_kuliah::class,
            'krs',
            'mahasiswa_id',
            'mata_kuliah_id'
        );
    }

    // <-- Tambahkan relasi jika mau akses $mahasiswa->prodi->nama
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

public function tahunAkademik()
{
    return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
}
}
