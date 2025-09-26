<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Guru;
use App\Models\Staf;
use Carbon\Carbon;


class GuruController extends Controller
{
    public function index()
    {
        $guru = \App\Models\Guru::where('user_id', auth()->id())->first();
        $pengumuman_terbaru = collect();
        $pengumuman_akademik = collect();
        if ($guru && $guru->sekolah_id) {
            $pengumuman_terbaru = \App\Models\PengumumanTerbaru::where('sekolah_id', $guru->sekolah_id)->orderBy('created_at', 'desc')->get();
            $pengumuman_akademik = \App\Models\PengumumanAkademik::where('sekolah_id', $guru->sekolah_id)->orderBy('created_at', 'desc')->get();
        }
        $pengumuman_terbaru->map(function ($item) {
            $item->created_at = \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta');
            return $item;
        });
        $pengumuman_akademik->map(function ($item) {
            $item->created_at = \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta');
            return $item;
        });
        // Greeting & hari
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $hour = $now->format('H');
        if($hour < 12){
            $greeting = 'Selamat Pagi';
        } elseif($hour < 15){
            $greeting = 'Selamat Siang';
        } elseif($hour < 18){
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }
        $userName = auth()->user()->name ?? 'Pengguna';
        $hariIndo = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        $hariNow = $hariIndo[$now->format('l')] ?? $now->format('l');
        $jadwalHariIni = \App\Models\JadwalPelajaran::where('guru', $userName)
            ->whereRaw('REPLACE(LOWER(hari), " ", "") = ?', [strtolower(str_replace(' ', '', $hariNow))])
            ->orderBy('jam_mulai')
            ->get();
        return view('guru.dashboard', compact('pengumuman_terbaru', 'pengumuman_akademik', 'greeting', 'userName', 'jadwalHariIni', 'hariNow', 'now'));
    }
}
