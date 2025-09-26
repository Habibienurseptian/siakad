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
        if ($murid) {
            $tagihanList = Tagihan::where('murid_id', $murid->id)->get();
        }
        return view('murid.pembayaran.index', compact('tagihanList'));
    }
}
