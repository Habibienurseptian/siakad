<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumumanAkademik extends Model
{
    protected $table = 'pengumuman_akademik';
    protected $fillable = ['judul', 'isi', 'sekolah_id'];
}
