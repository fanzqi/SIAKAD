<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
    use HasFactory, SoftDeletes;

    // Tabel yang digunakan
    protected $table = 'dosen';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'nidn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'email',
        'telepon',
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
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'dosen_id');
    }
}