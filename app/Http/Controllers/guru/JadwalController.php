<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalPelajaran;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        $guruNama = Auth::user()->name;

        // Set timezone ke WIB (Asia/Jakarta)
        $now = Carbon::now('Asia/Jakarta');

        // Konversi nama hari ke bahasa Indonesia
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

        // Ambil jadwal hari ini
        $jadwalHariIni = JadwalPelajaran::where('guru', $guruNama)
            ->whereRaw('LOWER(REPLACE(hari, " ", "")) = ?', [strtolower(str_replace(' ', '', $hariNow))])
            ->orderBy('jam_mulai')
            ->get();

        // Ambil jadwal minggu ini
        $jadwalMingguIni = JadwalPelajaran::where('guru', $guruNama)
            ->orderByRaw('FIELD(hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu")')
            ->orderBy('jam_mulai')
            ->get();

        return view('guru.jadwal.index', compact('jadwalHariIni', 'jadwalMingguIni', 'hariNow', 'now'));
    }
}
