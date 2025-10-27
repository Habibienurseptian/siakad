<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    use HasFactory;

    protected $table = 'stafs';

    protected $fillable = [
        'user_id',
        'nip',
        'sekolah_id',
        'bidang',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
    public function guru()
    {
        return $this->hasOne(Guru::class, 'nip', 'nip');
    }
}
