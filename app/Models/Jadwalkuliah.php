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
        'status',
    ];

    public function mata_kuliah()
    {
        return $this->belongsTo(Mata_kuliah::class, 'mata_kuliah_id');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruangs_id');
    }

    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

     public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

}
