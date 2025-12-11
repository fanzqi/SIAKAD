<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    // Nama tabel, kalau tidak pakai konvensi Laravel
    protected $table = 'kurikulums';

    // Field yang boleh diisi mass assignment
    protected $fillable = [
        'tahun_akademik_id',
        'kode_mk',
        'nama_mk',
        'sks',
        'wajib_pilihan',
        'prasyarat',
        'status',
    ];

    // Relasi ke tahun akademik
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }
}