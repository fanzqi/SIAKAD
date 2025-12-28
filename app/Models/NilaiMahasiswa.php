<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiMahasiswa extends Model
{
    protected $table = 'nilai_mahasiswa';

   protected $fillable = [
    'mahasiswa_id',
    'dosen_id',
    'mata_kuliah_id',
    'input_nilai_id',
    'tahun_akademik_id', 
    'kehadiran',
    'tugas',
    'uts',
    'uas',
    'nilai_akhir',
    'grade',
    'bobot',
];


    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function mata_kuliah()
    {
        return $this->belongsTo(Mata_kuliah::class, 'mata_kuliah_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function inputNilai()
    {
        return $this->belongsTo(InputNilai::class, 'input_nilai_id');
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(\App\Models\TahunAkademik::class, 'tahun_akademik_id');
    }
}
