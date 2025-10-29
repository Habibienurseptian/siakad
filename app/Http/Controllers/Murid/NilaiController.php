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
        $murid = Murid::with('kelas')->where('user_id', auth()->id())->first();

        $nilaiPublish = collect();

        if ($murid) {
            $nilaiPublish = Nilai::with('kelas')
                ->where('murid_id', $murid->id)
                ->where('status', 'publish')
                ->get();
        }

        return view('murid.jadwal.index', compact('nilaiPublish'));
    }
}
