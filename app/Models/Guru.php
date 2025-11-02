<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'user_id',
        'nip',
        'jenis_kelamin',
        'sekolah_id',
        'name',
        'email',
        'phone',
        'profile_image',
        'tempat_lahir',
        'tanggal_lahir',
        'warga_negara',
        'alamat',
        'kode_pos',
        'tempat_lahir_orangtua',
        'tanggal_lahir_orangtua',
        'status_marital',
        'nama_orangtua',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
    public function staf()
    {
        return $this->hasOne(Staf::class, 'nip', 'nip');
    }
}
