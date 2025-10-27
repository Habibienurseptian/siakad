<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Murid;
use App\Models\Nilai;

class JadwalController extends Controller
{
    public function index()
    {
        $murid = Murid::where('user_id', auth()->id())->first();

        $jadwalList = collect();
        $nilaiPublish = collect();

        if ($murid) {
            $jadwalList = JadwalPelajaran::where('sekolah_id', $murid->sekolah_id)
                ->where('kelas_id', $murid->kelas_id)
                ->orderByRaw('FIELD(hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu")')
                ->orderBy('jam_mulai')
                ->get();

            $nilaiPublish = Nilai::with('kelas')
                ->where('murid_id', $murid->id)
                ->where('status', 'publish')
                ->get();
        }

        return view('murid.jadwal.index', compact('jadwalList', 'nilaiPublish'));
    }
}
