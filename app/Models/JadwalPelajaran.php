<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajaran';
    protected $fillable = ['hari', 'jam_mulai', 'jam_selesai', 'mapel', 'guru', 'kelas', 'sekolah_id'];
}
