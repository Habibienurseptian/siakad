<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    protected $table = 'murids';

    protected $fillable = [
        'nomor_induk',
        'kelas',
        'user_id',
        'sekolah_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function tagihans()
    {
        // Eloquent sudah mengembalikan Collection kosong jika tidak ada data
        // Untuk keamanan ekstra, bisa tambahkan tipe return
        return $this->hasMany(Tagihan::class, 'murid_id') ?? collect();
    }
}
