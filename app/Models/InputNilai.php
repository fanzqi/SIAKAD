<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InputNilai extends Model
{
    use HasFactory;

    protected $table = 'input_nilai';

    protected $fillable = [
        'tahun_akademik_id',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_akhir',
        'status',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    // relasi ke nilai mahasiswa berdasarkan periode input nilai
    public function nilaiMahasiswa()
    {
        return $this->hasMany(\App\Models\NilaiMahasiswa::class, 'input_nilai_id');
    }

    // scope periode aktif berdasarkan tanggal & status
    public function scopeAktif(Builder $query): Builder
    {
        $now = now()->toDateString();

        return $query->where('status', 'Aktif')
            ->where('tanggal_mulai', '<=', $now)
            ->where('tanggal_akhir', '>=', $now);
    }

    // helper ambil periode aktif (opsional)
    public static function periodeAktifUntukTahun(?int $tahunAkademikId = null): ?self
    {
        $q = static::query()->aktif();

        if ($tahunAkademikId) {
            $q->where('tahun_akademik_id', $tahunAkademikId);
        }

        return $q->first();
    }
}
