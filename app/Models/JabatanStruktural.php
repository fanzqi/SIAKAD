<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanStruktural extends Model
{
    use HasFactory;

    protected $table = 'jabatan_struktural'; // tambahkan ini
    protected $fillable = [
        'dosen_id','jabatan','unit','mulai_jabatan','selesai_jabatan','status','id_prodi','id_fakultas'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}