<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use HasFactory, SoftDeletes;

    // Tabel yang digunakan
    protected $table = 'mahasiswa';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'nim',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'email',
        'telepon',
        'alamat',
        'fakultas',
        'prodi',
        'angkatan',
        'status',
        'foto',
        'fakultas_id',
        'prodi_id'
    ];

    // Casting tipe data
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke Fakultas
     */
    public function fakultasRelation()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    /**
     * Relasi ke Prodi
     */
public function programStudi()
{
    return $this->belongsTo(ProgramStudi::class, 'prodi_id', 'id');
}



}