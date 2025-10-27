<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    public function getTotalUnpaidTagihan()
    {
        return $this->tagihans->where('status', '!=', 'lunas')->sum(function($tagihan) {
            return ($tagihan->pembayaran_spp ?? 0)
                + ($tagihan->uang_saku ?? 0)
                + ($tagihan->uang_kegiatan ?? 0)
                + ($tagihan->uang_spi ?? 0)
                + ($tagihan->uang_haul_maulid ?? 0)
                + ($tagihan->uang_khidmah_infaq ?? 0)
                + ($tagihan->uang_zakat ?? 0);
        });
    }

    use HasFactory;

    protected $table = 'murids';

    protected $fillable = [
        'user_id',
        'nomor_induk',
        'kelas_id',
        'sekolah_id',
        'phone',
        'nama_orangtua',
        'telepon_orangtua',
        'profile_image',
        'tempat_lahir',
        'tanggal_lahir',
        'warga_negara',
        'alamat',
        'kode_pos',
        'tempat_lahir_orangtua',
        'tanggal_lahir_orangtua',
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
        return $this->hasMany(Tagihan::class, 'murid_id') ?? collect();
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
