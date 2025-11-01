<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Murid;
use App\Models\Sekolah;
use App\Models\Kelas;
use App\Models\SppItem;

class TagihanController extends Controller
{
    public function index()
    {
        $staf = \App\Models\Staf::where('user_id', auth()->id())->first();
        $sekolahs = collect();
        $filterStatus = request('status');

        if (!$staf || !$staf->sekolah_id) {
            return view('staf.tagihan.index', compact('sekolahs'));
        }

        $sekolah = Sekolah::with(['murids.user', 'murids.tagihans', 'murids.kelas'])->find($staf->sekolah_id);

        if (!$sekolah) {
            return view('staf.tagihan.index', compact('sekolahs'));
        }

        $muridsByKelas = [];
        $kelasGroups = $sekolah->murids->groupBy('kelas_id');

        foreach ($kelasGroups as $kelasId => $muridsAll) {
            $kelasObj = Kelas::find($kelasId);
            $namaKelas = $kelasObj ? strtoupper($kelasObj->nama_kelas) : 'TIDAK ADA KELAS';
            $muridsAll = $muridsAll->sortBy(fn($murid) => $murid->user->name ?? '')->values();

            // Filter berdasarkan status tagihan
            if ($filterStatus === 'lunas') {
                $muridsAll = $muridsAll->filter(fn($murid) =>
                    $murid->tagihans->count() > 0 &&
                    $murid->tagihans->where('status', '!=', 'lunas')->count() == 0
                )->values();
            } elseif ($filterStatus === 'belum_lunas') {
                $muridsAll = $muridsAll->filter(fn($murid) =>
                    $murid->tagihans->count() > 0 &&
                    $murid->tagihans->where('status', '!=', 'lunas')->count() > 0
                )->values();
            } elseif ($filterStatus === 'belum_ada_tagihan') {
                $muridsAll = $muridsAll->filter(fn($murid) =>
                    $murid->tagihans->count() == 0
                )->values();
            }

            // Filter search
            $search = request('search');
            if (!empty($search)) {
                $muridsAll = $muridsAll->filter(function($murid) use ($search) {
                    $nama = strtolower($murid->user->name ?? '');
                    $nomor = strtolower($murid->nomor_induk ?? '');
                    $search = strtolower($search);
                    return str_contains($nama, $search) || str_contains($nomor, $search);
                })->values();
            }

            // Hitung total unpaid tagihan
            foreach ($muridsAll as $murid) {
                $murid->totalUnpaidTagihan = $murid->getTotalUnpaidTagihan();
            }

            if ($muridsAll->count() > 0) {
                $muridsByKelas[$namaKelas] = $muridsAll;
            }
        }

        ksort($muridsByKelas);
        $sekolah->muridsByKelas = $muridsByKelas;
        $sekolahs = collect([$sekolah]);

        return view('staf.tagihan.index', compact('sekolahs'));
    }

    public function create($murid_id)
    {
        $murid = Murid::findOrFail($murid_id);
        $sppItems = SppItem::all();
        $totalSpp = $sppItems->sum('jumlah_default');

        return view('staf.tagihan.create', compact('murid', 'sppItems', 'totalSpp'));
    }

    public function store(Request $request, $murid_id)
    {
        $request->validate([
            'periode' => 'required|string',
            'spi' => 'nullable|numeric|min:0',
            'tagihan_kegiatan' => 'nullable|numeric|min:0',
            'tagihan_semester_ganjil' => 'nullable|numeric|min:0',
            'tagihan_semester_genap' => 'nullable|numeric|min:0',
            'haul' => 'nullable|numeric|min:0',
        ]);

        $murid = Murid::findOrFail($murid_id);

        $totalSpp = SppItem::sum('jumlah_default');

        Tagihan::create([
            'murid_id' => $murid->id,
            'spp' => $totalSpp,
            'spi' => $request->spi ?? 0,
            'tagihan_kegiatan' => $request->tagihan_kegiatan ?? 0,
            'tagihan_semester_ganjil' => $request->tagihan_semester_ganjil ?? 0,
            'tagihan_semester_genap' => $request->tagihan_semester_genap ?? 0,
            'haul' => $request->haul ?? 0,
            'status' => 'belum_lunas',
            'periode' => $request->periode,
        ]);

        return redirect()->route('staf.tagihan.index')->with('success', 'Tagihan berhasil ditambahkan');
    }

    public function createMass($sekolah_id)
    {
        $sekolah = Sekolah::with('murids', 'kelas')->findOrFail($sekolah_id);
        $sppItems = SppItem::all();
        $totalSpp = $sppItems->sum('jumlah_default');

        // ambil daftar kelas
        $kelasList = $sekolah->kelas;

        return view('staf.tagihan.create_mass', compact('sekolah', 'sppItems', 'totalSpp', 'kelasList'));
    }

    public function storeMass(Request $request, $sekolah_id)
    {
        $request->validate([
            'periode' => 'required|string',
            'kelas_id' => 'nullable|exists:kelas,id',
            'spi' => 'nullable|numeric|min:0',
            'tagihan_kegiatan' => 'nullable|numeric|min:0',
            'tagihan_semester_ganjil' => 'nullable|numeric|min:0',
            'tagihan_semester_genap' => 'nullable|numeric|min:0',
            'haul' => 'nullable|numeric|min:0',
        ]);

        $sekolah = Sekolah::with('murids')->findOrFail($sekolah_id);

        $murids = $request->kelas_id 
            ? $sekolah->murids->where('kelas_id', $request->kelas_id) 
            : $sekolah->murids;

        $totalSpp = SppItem::sum('jumlah_default');

        foreach ($murids as $murid) {
            Tagihan::create([
                'murid_id' => $murid->id,
                'spp' => $totalSpp,
                'spi' => $request->spi ?? 0,
                'tagihan_kegiatan' => $request->tagihan_kegiatan ?? 0,
                'tagihan_semester_ganjil' => $request->tagihan_semester_ganjil ?? 0,
                'tagihan_semester_genap' => $request->tagihan_semester_genap ?? 0,
                'haul' => $request->haul ?? 0,
                'status' => 'belum_lunas',
                'periode' => $request->periode,
            ]);
        }

        return redirect()->route('staf.tagihan.index')->with('success', 'Tagihan massal berhasil ditambahkan');
    }


    public function show($murid_id)
    {
        $murid = Murid::with(['user', 'sekolah', 'tagihans', 'kelas'])->findOrFail($murid_id);
        $sppItems = SppItem::all(); // semua SPP yang dibuat staf keuangan
        $totalSpp = $sppItems->sum('jumlah_default');

        // Tambahkan total tagihan per tagihan
        foreach ($murid->tagihans as $tagihan) {
            $tagihan->totalSpp = $totalSpp;
            $tagihan->totalTagihan = $totalSpp
                + ($tagihan->spi ?? 0)
                + ($tagihan->tagihan_kegiatan ?? 0)
                + ($tagihan->tagihan_semester_ganjil ?? 0)
                + ($tagihan->tagihan_semester_genap ?? 0)
                + ($tagihan->haul ?? 0);
        }

        return view('staf.tagihan.show', compact('murid', 'sppItems'));
    }


    public function edit($id)
    {
        $tagihan = Tagihan::with('murid.user', 'murid.kelas')->findOrFail($id);
        $sppItems = SppItem::all();

        // Hitung total SPP dari semua item
        $totalSpp = $sppItems->sum('jumlah_default');

        // Total tagihan keseluruhan
        $totalTagihan = $totalSpp
            + ($tagihan->spi ?? 0)
            + ($tagihan->tagihan_kegiatan ?? 0)
            + ($tagihan->tagihan_semester_ganjil ?? 0)
            + ($tagihan->tagihan_semester_genap ?? 0)
            + ($tagihan->haul ?? 0);

        return view('staf.tagihan.edit', compact('tagihan', 'sppItems', 'totalSpp', 'totalTagihan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:lunas,belum_lunas',
            'periode' => 'required|string',
            'spi' => 'nullable|numeric|min:0',
            'tagihan_kegiatan' => 'nullable|numeric|min:0',
            'tagihan_semester_ganjil' => 'nullable|numeric|min:0',
            'tagihan_semester_genap' => 'nullable|numeric|min:0',
            'haul' => 'nullable|numeric|min:0',
        ]);

        $tagihan = Tagihan::findOrFail($id);

        $totalSpp = SppItem::sum('jumlah_default');

        $tagihan->update([
            'spp' => $totalSpp,
            'spi' => $request->spi ?? 0,
            'tagihan_kegiatan' => $request->tagihan_kegiatan ?? 0,
            'tagihan_semester_ganjil' => $request->tagihan_semester_ganjil ?? 0,
            'tagihan_semester_genap' => $request->tagihan_semester_genap ?? 0,
            'haul' => $request->haul ?? 0,
            'status' => $request->status,
            'periode' => $request->periode,
        ]);

        return redirect()->route('staf.tagihan.detail', $tagihan->murid_id)->with('success', 'Tagihan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();
        return redirect()->back()->with('success', 'Tagihan berhasil dihapus.');
    }
}
