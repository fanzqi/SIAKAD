<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMengajar extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'mata_kuliah_id',
        'ruangs_id',
        'semester',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'group_kelas', // pastikan ada
    ];

    public function mata_kuliah()
    {
        return $this->belongsTo(Mata_kuliah::class);
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruangs_id');
    }
}