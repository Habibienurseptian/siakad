<?php
namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Murid;

class PembayaranController extends Controller
{
    public function index()
    {
        $murid = Murid::where('user_id', auth()->id())->first();
        $tagihanList = collect();
        $belumLunas = collect();
        $totalList = collect();
        if ($murid) {
            $tagihanList = Tagihan::where('murid_id', $murid->id)->get();
            $belumLunas = $tagihanList->where('status', '!=', 'lunas');
            $totalList = $tagihanList->map(function($tagihan) {
                return (
                    ($tagihan->pembayaran_spp ?? 0) +
                    ($tagihan->uang_saku ?? 0) +
                    ($tagihan->uang_kegiatan ?? 0) +
                    ($tagihan->uang_spi ?? 0) +
                    ($tagihan->uang_haul_maulid ?? 0) +
                    ($tagihan->uang_khidmah_infaq ?? 0) +
                    ($tagihan->uang_zakat ?? 0)
                );
            });
        }
        $grandTotal = $totalList->sum();
        return view('murid.pembayaran.index', compact('tagihanList', 'belumLunas', 'totalList', 'grandTotal'));
    }
}
