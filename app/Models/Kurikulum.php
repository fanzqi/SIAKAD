<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikulums';

    protected $fillable = [
        'tahun_akademik_id',
        'kode_mk',
        'nama_mk',
        'semester',
        'sks',
        'wajib_pilihan',
        'prasyarat',
        'status',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

}