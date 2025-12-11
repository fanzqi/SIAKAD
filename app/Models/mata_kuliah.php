<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mata_kuliah extends Model
{
    protected $table = 'mata_kuliah';

    protected $fillable = [
        'kode',
        'nama_mata_kuliah',
        'dosen',
        'fakultas',
        'program_studi',
        'sks',
    ];
}