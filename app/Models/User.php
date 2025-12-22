<?php

namespace App\Models;
use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user')
            ->withPivot('is_read')
            ->withTimestamps();
    }

    use Notifiable;

    protected $fillable = [
        'name',
        'dosen_id',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // gunakan username sebagai field login
    public function username()
    {
        return 'username';
    }
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function getNamaAttribute(): string
    {
        return match ($this->role) {
            'dosen' => $this->dosen?->nama_dosen ?? $this->name,
            'mahasiswa' => $this->mahasiswa?->nama_mahasiswa ?? $this->name,
            default => $this->name,
        };
    }
}