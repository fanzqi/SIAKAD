<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends Model
{
    use SoftDeletes; // opsional, kalau tabel pakai soft delete

    protected $table = 'program_studi'; // nama tabel
    protected $fillable = [
        'nama',
        'fakultas_id',
    ];

    /**
     * Relasi ke Fakultas
     * Satu program studi dimiliki oleh satu fakultas
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    /**
     * Relasi ke Dosen
     * Satu program studi bisa memiliki banyak dosen
     */
    public function dosens()
    {
        return $this->hasMany(Dosen::class, 'prodi_id');
    }

    /**
     * Relasi ke Mata Kuliah
     * Satu program studi bisa memiliki banyak mata kuliah
     */
    public function mataKuliahs()
    {
        return $this->hasMany(Mata_Kuliah::class, 'prodi_id');
    }
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'prodi_id', 'id');
    }
}