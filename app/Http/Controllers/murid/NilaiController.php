<?php
namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Murid;

class NilaiController extends Controller
{
    public function index()
    {
        $murid = Murid::where('user_id', auth()->id())->first();
        $nilaiList = collect();
        $nilaiPublish = collect();
        if ($murid) {
            $nilaiList = Nilai::where('murid_id', $murid->id)->get();
            $nilaiPublish = $nilaiList->where('status', 'publish');
        }
        return view('murid.nilai.index', compact('nilaiList', 'nilaiPublish'));
    }
}
