<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'murid_id',
        'spp',
        'spi',
        'tagihan_kegiatan',
        'tagihan_semester_ganjil',
        'tagihan_semester_genap',
        'haul',
        'status',
        'periode',
    ];


    // Relasi
    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function items()
    {
        return $this->hasMany(TagihanItem::class);
    }

    public function sppItem()
    {
        return $this->belongsTo(SppItem::class, 'spp');
    }
}