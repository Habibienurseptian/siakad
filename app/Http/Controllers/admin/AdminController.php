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
        return view('admin.dashboard', compact('data'));
    }
}
