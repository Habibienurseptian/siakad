<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model 
{
    use HasFactory;

    protected $table = 'sekolahs';

    protected $fillable = [
        'nama',
        'alamat',
        'kepala_sekolah',
        'npsn',
    ];

    public function gurus()
    {
        return $this->hasMany(Guru::class, 'sekolah_id');
    }

    public function murids()
    {
        return $this->hasMany(Murid::class, 'sekolah_id');
    }

    public function stafs()
    {
        return $this->hasMany(Staf::class, 'sekolah_id');
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class, 'sekolah_id');
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'sekolah_id');
    }
}
