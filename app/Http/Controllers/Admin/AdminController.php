<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Guru;
use App\Models\Staf;
use App\Models\Sekolah;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'totalSiswa' => Murid::count(),
            'totalGuru'  => Guru::count(),
            'totalStaf'  => Staf::count(),
            'totalSekolah' => Sekolah::count(),
        ];

        // Mendapatkan waktu sekarang di zona Jakarta (WIB)
        $hour = now()->setTimezone('Asia/Jakarta')->format('H');

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

        return view('admin.dashboard', compact('data', 'greeting', 'userName'));
    }
}
