<?php
namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Models\Murid;
use App\Models\Nilai;

class JadwalController extends Controller
{
    public function index()
    {
        $murid = Murid::where('user_id', auth()->id())->first();
        $jadwalList = collect();
        $nilaiList = collect();
        $nilaiPublish = collect();
        if ($murid) {
            $jadwalList = JadwalPelajaran::where('sekolah_id', $murid->sekolah_id)
                ->whereRaw('REPLACE(LOWER(kelas), " ", "") = ?', [strtolower(str_replace(' ', '', $murid->kelas))])
                ->orderByRaw('FIELD(hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu")')
                ->orderBy('jam_mulai')
                ->get();
            $nilaiList = Nilai::where('murid_id', $murid->id)->get();
            $nilaiPublish = $nilaiList->where('status', 'publish');
        }
        return view('murid.jadwal.index', compact('jadwalList', 'nilaiList', 'nilaiPublish'));
    }
}
