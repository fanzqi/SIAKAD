<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table = 'tahun_akademik';

    protected $fillable = [
        'tahun_akademik',
        'semester',
        'status'
    ];

    public function inputNilai()
    {
        return $this->hasMany(InputNilai::class);
    }

     // Relasi ke Kurikulum
    public function kurikulums()
    {
        return $this->hasMany(Kurikulum::class);
    }
}