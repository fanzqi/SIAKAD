<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mata_kuliah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mata_kuliah';

    protected $fillable = [
        'kode',
        'nama_mata_kuliah',
        'sks',
        'semester',
        'group',
        'dosen_id',
        'fakultas_id',
        'program_studi_id',
    ];

    // ===========================
    // RELASI
    // ===========================

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwalkuliah::class, 'mata_kuliah_id');
    }
}
