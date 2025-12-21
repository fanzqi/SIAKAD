<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMahasiswa extends Model
{
    protected $table = 'nilai_mahasiswa';

    protected $primaryKey = 'id_nilaimahasiswa';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_mahasiswa',
        'nilai_angka_absen',
        'nilai_angka_tugas',
        'nilai_angka_uts',
        'nilai_angka_uas',
        'nilai_angka_akhir',
        'nilai_huruf',
        'bobot',
    ];

    public function mahasiswa()
{
    return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
}

}
