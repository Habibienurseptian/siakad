<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'wali_kelas',
        'jumlah_siswa',
        'sekolah_id',
    ];

    // Jika ada relasi ke Sekolah
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
    
}
