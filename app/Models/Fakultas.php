<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $fillable = ['nama'];

    public function prodis() {
        return $this->hasMany(ProgramStudi::class, 'fakultas_id');
    }

    public function dosen() {
        return $this->hasMany(Dosen::class, 'fakultas_id');
    }
}
