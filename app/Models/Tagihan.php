<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihans';

    protected $fillable = [
        'murid_id',
        'pembayaran_spp',
        'uang_saku',
        'uang_kegiatan',
        'uang_spi',
        'uang_haul_maulid',
        'uang_khidmah_infaq',
        'uang_zakat',
        'status', // 'lunas' atau 'belum_lunas'
        'periode',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id');
    }
}
