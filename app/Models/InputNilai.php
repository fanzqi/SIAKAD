<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputNilai extends Model
{
    use HasFactory;

    // Nama tabel sesuai database
    protected $table = 'input_nilai';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'tahun_akademik_id',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_akhir',
        'status',
    ];

    // Relasi ke TahunAkademik
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }
}
