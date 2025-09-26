<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $fillable = ['murid_id', 'kelas', 'mapel', 'jadwal_id', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'status'];

    public function murid()
    {
        return $this->belongsTo(\App\Models\Murid::class, 'murid_id');
    }
}
