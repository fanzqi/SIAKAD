<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputNilai extends Model
{
    protected $table = 'input_nilai';

    protected $fillable = [
        'tahun_akademik_id',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_akhir',
        'status'
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }
}