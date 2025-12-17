<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mata_kuliah extends Model
{

    use HasFactory;

    protected $table = 'mata_kuliah'; // nama tabel yang benar

    protected $fillable = [
        'dosen_id',
        'fakultas_id',
        'program_studi_id',
        'kode',
        'nama_mata_kuliah',
        'sks',
        'group'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

}