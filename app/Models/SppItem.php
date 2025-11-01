<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tagihan;

class SppItem extends Model
{
    protected $fillable = ['nama', 'jumlah_default'];

    protected static function booted()
    {
        static::saved(function ($sppItem) {
            self::updateAllTagihanTotalSpp();
        });

        static::deleted(function ($sppItem) {
            self::updateAllTagihanTotalSpp();
        });
    }

    public static function updateAllTagihanTotalSpp()
    {
        $totalSpp = self::sum('jumlah_default');
        \App\Models\Tagihan::query()->update(['spp' => $totalSpp]);
    }
}
