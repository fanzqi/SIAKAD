<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TahunAkademik;
use App\Models\mata_kuliah;
//use App\Models\dosen;

class PlotingDosen extends Model
{
    protected $table = 'ploting_dosen';

    protected $fillable = [
        'nama_mata_kuliah_id',
        'dosen',
        'kelas',
        'semester_id',
        'status',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'semester_id', 'id');
    }

      // 🔗 nama_mata_kuliah_id → mata_kuliah
    public function mataKuliah()
    {
        return $this->belongsTo(mata_kuliah::class, 'nama_mata_kuliah_id', 'id');
    }

    // 🔗 dosen_id → dosen (NANTI)
    //public function dosen()
    //{
        //return $this->belongsTo(dosen::class, 'dosen_id', 'id');
    //}
}