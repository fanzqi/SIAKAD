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
     * Relasi ke Prodi
     */
   public function user()
{
    return $this->belongsTo(User::class);
}

public function fakultas()
{
    return $this->belongsTo(Fakultas::class);
}

public function programStudi()
{
    return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
}

}
