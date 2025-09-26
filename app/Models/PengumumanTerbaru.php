<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumumanTerbaru extends Model
{
    protected $table = 'pengumuman_terbaru';
    protected $fillable = ['judul', 'isi', 'sekolah_id'];
}
