<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Guru;
use App\Models\Staf;
use Carbon\Carbon;


class StafController extends Controller
{
    public function index()
    {
        $staf = Staf::where('user_id', auth()->id())->first();

        // Jika staf terkait dengan sekolah, hitung ringkasan berdasarkan sekolah tersebut
        if ($staf && $staf->sekolah_id) {
            $sekolahId = $staf->sekolah_id;
            $data = [
                'totalSiswa' => Murid::where('sekolah_id', $sekolahId)->count(),
                'totalGuru'  => Guru::where('sekolah_id', $sekolahId)->count(),
                'totalStaf'  => Staf::where('sekolah_id', $sekolahId)->count(),
            ];
        } else {
            // fallback ke total global jika staf tidak terkait sekolah
            $data = [
                'totalSiswa' => Murid::count(),
                'totalGuru'  => Guru::count(),
                'totalStaf'  => Staf::count(),
            ];
        }
        $pengumuman_terbaru = collect();
        $pengumuman_akademik = collect();
        if ($staf && $staf->sekolah_id) {
            $pengumuman_terbaru = \App\Models\PengumumanTerbaru::where('sekolah_id', $staf->sekolah_id)->orderBy('created_at', 'desc')->get();
            $pengumuman_akademik = \App\Models\PengumumanAkademik::where('sekolah_id', $staf->sekolah_id)->orderBy('created_at', 'desc')->get();
        }
        $pengumuman_terbaru->map(function ($item) {
            $item->created_at = Carbon::parse($item->created_at)->timezone('Asia/Jakarta');
            return $item;
        });
        $pengumuman_akademik->map(function ($item) {
            $item->created_at = Carbon::parse($item->created_at)->timezone('Asia/Jakarta');
            return $item;
        });

        $hour = Carbon::now('Asia/Jakarta')->format('H');
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

        return view('staf.dashboard', compact('data', 'pengumuman_terbaru', 'pengumuman_akademik', 'greeting', 'userName'));
    }
}
