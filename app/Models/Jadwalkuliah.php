<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwalkuliah extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'mata_kuliah',
        'dosen',
        'program_studi',
        'semester',
        'hari',
        'jam',
        'ruangan'
    ];
}
