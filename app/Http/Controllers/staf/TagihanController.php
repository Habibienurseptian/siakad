<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Murid;
use App\Models\Sekolah;

class TagihanController extends Controller
{
    public function index()
    {
        $staf = \App\Models\Staf::where('user_id', auth()->id())->first();
        $sekolahs = collect();
        $filterStatus = request('status');
        if ($staf && $staf->sekolah_id) {
            $sekolah = Sekolah::with(['murids.user', 'murids.tagihans'])->find($staf->sekolah_id);
            if ($sekolah) {
                $muridsByKelas = [];
                $kelasGroups = $sekolah->murids->groupBy('kelas');
                foreach ($kelasGroups as $kelas => $muridsAll) {
                    // Urutkan murid berdasarkan nama
                    $muridsAll = $muridsAll->sortBy(function($murid) {
                        return $murid->user->name ?? '';
                    })->values();
                    // Filter murid sesuai status
                    if ($filterStatus === 'lunas') {
                        $muridsAll = $muridsAll->filter(function($murid) {
                            return $murid->tagihans->where('status', 'lunas')->count() > 0;
                        })->values();
                    } elseif ($filterStatus === 'belum_lunas') {
                        $muridsAll = $muridsAll->filter(function($murid) {
                            return $murid->tagihans->where('status', '!=', 'lunas')->count() > 0;
                        })->values();
                    } elseif ($filterStatus === 'belum_ada_tagihan') {
                        $muridsAll = $muridsAll->filter(function($murid) {
                            return $murid->tagihans->count() == 0;
                        })->values();
                    }
                    // Hitung total tagihan per murid
                    foreach ($muridsAll as $murid) {
                        if ($filterStatus === 'lunas') {
                            $murid->totalTagihan = $murid->tagihans
                                ->where('status', 'lunas')
                                ->sum(function($tagihan) {
                                    return (float) ($tagihan->jumlah ?? 0)
                                        + (float) ($tagihan->pembayaran_spp ?? 0)
                                        + (float) ($tagihan->uang_saku ?? 0)
                                        + (float) ($tagihan->uang_kegiatan ?? 0)
                                        + (float) ($tagihan->uang_spi ?? 0)
                                        + (float) ($tagihan->uang_haul_maulid ?? 0)
                                        + (float) ($tagihan->uang_khidmah_infaq ?? 0)
                                        + (float) ($tagihan->uang_zakat ?? 0);
                                });
                        } elseif ($filterStatus === 'belum_lunas') {
                            $murid->totalTagihan = $murid->tagihans
                                ->where('status', '!=', 'lunas')
                                ->sum(function($tagihan) {
                                    return (float) ($tagihan->jumlah ?? 0)
                                        + (float) ($tagihan->pembayaran_spp ?? 0)
                                        + (float) ($tagihan->uang_saku ?? 0)
                                        + (float) ($tagihan->uang_kegiatan ?? 0)
                                        + (float) ($tagihan->uang_spi ?? 0)
                                        + (float) ($tagihan->uang_haul_maulid ?? 0)
                                        + (float) ($tagihan->uang_khidmah_infaq ?? 0)
                                        + (float) ($tagihan->uang_zakat ?? 0);
                                });
                        } else {
                            $murid->totalTagihan = $murid->tagihans
                                ->sum(function($tagihan) {
                                    return (float) ($tagihan->jumlah ?? 0)
                                        + (float) ($tagihan->pembayaran_spp ?? 0)
                                        + (float) ($tagihan->uang_saku ?? 0)
                                        + (float) ($tagihan->uang_kegiatan ?? 0)
                                        + (float) ($tagihan->uang_spi ?? 0)
                                        + (float) ($tagihan->uang_haul_maulid ?? 0)
                                        + (float) ($tagihan->uang_khidmah_infaq ?? 0)
                                        + (float) ($tagihan->uang_zakat ?? 0);
                                });
                        }
                    }
                    $muridsByKelas[$kelas] = $muridsAll;
                }
                $sekolah->muridsByKelas = $muridsByKelas;
                $sekolahs = collect([$sekolah]);
            }
        }
        return view('staf.pembayaran.index', compact('sekolahs'));
    }

    // Tampilkan form input tagihan untuk satu murid
    public function create($murid_id)
    {
        $murid = Murid::with('sekolah', 'user')->findOrFail($murid_id);
        return view('staf.pembayaran.create', compact('murid'));
    }

    // Simpan tagihan satu murid
    public function store(Request $request, $murid_id)
    {
        $request->validate([
            'periode' => 'required',
            'pembayaran_spp' => 'nullable|numeric',
            'uang_saku' => 'nullable|numeric',
            'uang_kegiatan' => 'nullable|numeric',
            'uang_spi' => 'nullable|numeric',
            'uang_haul_maulid' => 'nullable|numeric',
            'uang_khidmah_infaq' => 'nullable|numeric',
            'uang_zakat' => 'nullable|numeric',
        ]);
        if (
            empty($request->pembayaran_spp) &&
            empty($request->uang_saku) &&
            empty($request->uang_kegiatan) &&
            empty($request->uang_spi) &&
            empty($request->uang_haul_maulid) &&
            empty($request->uang_khidmah_infaq) &&
            empty($request->uang_zakat)
        ) {
            return back()->withErrors(['Minimal satu komponen tagihan harus diisi.'])->withInput();
        }
        $jumlah =
            ($request->pembayaran_spp ?? 0) +
            ($request->uang_saku ?? 0) +
            ($request->uang_kegiatan ?? 0) +
            ($request->uang_spi ?? 0) +
            ($request->uang_haul_maulid ?? 0) +
            ($request->uang_khidmah_infaq ?? 0) +
            ($request->uang_zakat ?? 0);
        Tagihan::create([
            'murid_id' => $murid_id,
            'pembayaran_spp' => $request->pembayaran_spp,
            'uang_saku' => $request->uang_saku,
            'uang_kegiatan' => $request->uang_kegiatan,
            'uang_spi' => $request->uang_spi,
            'uang_haul_maulid' => $request->uang_haul_maulid,
            'uang_khidmah_infaq' => $request->uang_khidmah_infaq,
            'uang_zakat' => $request->uang_zakat,
            'jumlah' => $jumlah,
            'status' => 'belum_lunas',
            'periode' => $request->periode,
        ]);
        return redirect()->route('staf.pembayaran.index')->with('success', 'Tagihan berhasil ditambahkan');
    }

    // Tampilkan form input tagihan untuk semua murid di sekolah tertentu
    public function createMass($sekolah_id)
    {
        $sekolah = Sekolah::with('murids.user')->findOrFail($sekolah_id);
        return view('staf.pembayaran.create_mass', compact('sekolah'));
    }

    // Simpan tagihan untuk semua murid di sekolah tertentu
    public function storeMass(Request $request, $sekolah_id)
    {
        $request->validate([
            'periode' => 'required',
            'pembayaran_spp' => 'nullable|numeric',
            'uang_saku' => 'nullable|numeric',
            'uang_kegiatan' => 'nullable|numeric',
            'uang_spi' => 'nullable|numeric',
            'uang_haul_maulid' => 'nullable|numeric',
            'uang_khidmah_infaq' => 'nullable|numeric',
            'uang_zakat' => 'nullable|numeric',
        ]);
        if (
            empty($request->pembayaran_spp) &&
            empty($request->uang_saku) &&
            empty($request->uang_kegiatan) &&
            empty($request->uang_spi) &&
            empty($request->uang_haul_maulid) &&
            empty($request->uang_khidmah_infaq) &&
            empty($request->uang_zakat)
        ) {
            return back()->withErrors(['Minimal satu komponen tagihan harus diisi.'])->withInput();
        }
        $sekolah = Sekolah::with('murids')->findOrFail($sekolah_id);
        $jumlah =
            ($request->pembayaran_spp ?? 0) +
            ($request->uang_saku ?? 0) +
            ($request->uang_kegiatan ?? 0) +
            ($request->uang_spi ?? 0) +
            ($request->uang_haul_maulid ?? 0) +
            ($request->uang_khidmah_infaq ?? 0) +
            ($request->uang_zakat ?? 0);
        foreach ($sekolah->murids as $murid) {
            Tagihan::create([
                'murid_id' => $murid->id,
                'pembayaran_spp' => $request->pembayaran_spp,
                'uang_saku' => $request->uang_saku,
                'uang_kegiatan' => $request->uang_kegiatan,
                'uang_spi' => $request->uang_spi,
                'uang_haul_maulid' => $request->uang_haul_maulid,
                'uang_khidmah_infaq' => $request->uang_khidmah_infaq,
                'uang_zakat' => $request->uang_zakat,
                'jumlah' => $jumlah,
                'status' => 'belum_lunas',
                'periode' => $request->periode,
            ]);
        }
        return redirect()->route('staf.pembayaran.index')->with('success', 'Tagihan massal berhasil ditambahkan');
    }

    public function show($murid_id)
    {
        $murid = Murid::with(['user', 'sekolah', 'tagihans'])->findOrFail($murid_id);
        return view('staf.pembayaran.show', compact('murid'));
    }

    public function edit($id)
	{
		$tagihan = Tagihan::with('murid.user')->findOrFail($id);
		return view('staf.pembayaran.edit', compact('tagihan'));
	}

	public function update(Request $request, $id)
	{
        $request->validate([
            'periode' => 'required',
            'status' => 'required|in:lunas,belum_lunas',
            'pembayaran_spp' => 'nullable|numeric',
            'uang_saku' => 'nullable|numeric',
            'uang_kegiatan' => 'nullable|numeric',
            'uang_spi' => 'nullable|numeric',
            'uang_haul_maulid' => 'nullable|numeric',
            'uang_khidmah_infaq' => 'nullable|numeric',
            'uang_zakat' => 'nullable|numeric',
        ]);
        if (
            empty($request->pembayaran_spp) &&
            empty($request->uang_saku) &&
            empty($request->uang_kegiatan) &&
            empty($request->uang_spi) &&
            empty($request->uang_haul_maulid) &&
            empty($request->uang_khidmah_infaq) &&
            empty($request->uang_zakat)
        ) {
            return back()->withErrors(['Minimal satu komponen tagihan harus diisi.'])->withInput();
        }
        $jumlah =
            ($request->pembayaran_spp ?? 0) +
            ($request->uang_saku ?? 0) +
            ($request->uang_kegiatan ?? 0) +
            ($request->uang_spi ?? 0) +
            ($request->uang_haul_maulid ?? 0) +
            ($request->uang_khidmah_infaq ?? 0) +
            ($request->uang_zakat ?? 0);
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update([
            'pembayaran_spp' => $request->pembayaran_spp,
            'uang_saku' => $request->uang_saku,
            'uang_kegiatan' => $request->uang_kegiatan,
            'uang_spi' => $request->uang_spi,
            'uang_haul_maulid' => $request->uang_haul_maulid,
            'uang_khidmah_infaq' => $request->uang_khidmah_infaq,
            'uang_zakat' => $request->uang_zakat,
            'jumlah' => $jumlah,
            'periode' => $request->periode,
            'status' => $request->status,
        ]);
		return redirect()->route('staf.pembayaran.detail', $tagihan->murid_id)->with('success', 'Tagihan berhasil diupdate');
	}


    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();
        return redirect()->back()->with('success', 'Tagihan berhasil dihapus.');
    }
}
