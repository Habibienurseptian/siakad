<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Murid;
use App\Models\Sekolah;
use App\Models\Kelas;

class TagihanController extends Controller
{
    public function index()
    {
        $staf = \App\Models\Staf::where('user_id', auth()->id())->first();
        $sekolahs = collect();
        $filterStatus = request('status');

        if ($staf && $staf->sekolah_id) {
            $sekolah = Sekolah::with(['murids.user', 'murids.tagihans', 'murids.kelas'])->find($staf->sekolah_id);

            if ($sekolah) {
                $muridsByKelas = [];

                // Group by kelas_id dan ambil relasi kelas
                $kelasGroups = $sekolah->murids->groupBy('kelas_id');

                foreach ($kelasGroups as $kelasId => $muridsAll) {
                    // Ambil nama kelas dari relasi
                    $kelasObj = Kelas::find($kelasId);
                    $namaKelas = $kelasObj ? strtoupper($kelasObj->nama_kelas) : 'TIDAK ADA KELAS';

                    // Urutkan murid berdasarkan nama
                    $muridsAll = $muridsAll->sortBy(function($murid) {
                        return $murid->user->name ?? '';
                    })->values();

                    // Filter berdasarkan status tagihan
                    if ($filterStatus === 'lunas') {
                        $muridsAll = $muridsAll->filter(function($murid) {
                            return $murid->tagihans->count() > 0 &&
                                $murid->tagihans->where('status', '!=', 'lunas')->count() == 0;
                        })->values();
                    } elseif ($filterStatus === 'belum_lunas') {
                        $muridsAll = $muridsAll->filter(function($murid) {
                            return $murid->tagihans->count() > 0 &&
                                $murid->tagihans->where('status', '!=', 'lunas')->count() > 0;
                        })->values();
                    } elseif ($filterStatus === 'belum_ada_tagihan') {
                        $muridsAll = $muridsAll->filter(function($murid) {
                            return $murid->tagihans->count() == 0;
                        })->values();
                    }

                    // Filter pencarian nama atau nomor induk
                    $search = request('search');
                    if (!empty($search)) {
                        $muridsAll = $muridsAll->filter(function($murid) use ($search) {
                            $nama = strtolower($murid->user->name ?? '');
                            $nomor = strtolower($murid->nomor_induk ?? '');
                            $search = strtolower($search);
                            return str_contains($nama, $search) || str_contains($nomor, $search);
                        })->values();
                    }

                    // Hitung total tagihan belum dibayar
                    foreach ($muridsAll as $murid) {
                        $murid->totalUnpaidTagihan = $murid->getTotalUnpaidTagihan();
                    }

                    // Skip kelas jika tidak ada murid setelah filter
                    if ($muridsAll->count() > 0) {
                        $muridsByKelas[$namaKelas] = $muridsAll;
                    }
                }

                // Urutkan kelas berdasarkan nama
                ksort($muridsByKelas);

                $sekolah->muridsByKelas = $muridsByKelas;
                $sekolahs = collect([$sekolah]);
            }
        }

        return view('staf.pembayaran.index', compact('sekolahs'));
    }


    // Tampilkan form input tagihan untuk satu murid
    public function create($murid_id)
    {
        $murid = Murid::with('sekolah', 'user', 'kelas')->findOrFail($murid_id);
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
        $sekolah = Sekolah::with('murids.user', 'murids.kelas')->findOrFail($sekolah_id);
        
        // Group murids by kelas untuk tampilan yang lebih terorganisir
        $muridsByKelas = $sekolah->murids->groupBy('kelas_id')->map(function($murids, $kelasId) {
            $kelasObj = Kelas::find($kelasId);
            return [
                'nama_kelas' => $kelasObj ? $kelasObj->nama_kelas : 'Tidak Ada Kelas',
                'murids' => $murids->sortBy(function($murid) {
                    return $murid->user->name ?? '';
                })
            ];
        })->sortBy('nama_kelas');

        return view('staf.pembayaran.create_mass', compact('sekolah', 'muridsByKelas'));
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
        $murid = Murid::with(['user', 'sekolah', 'tagihans', 'kelas'])->findOrFail($murid_id);
        return view('staf.pembayaran.show', compact('murid'));
    }

    public function edit($id)
    {
        $tagihan = Tagihan::with('murid.user', 'murid.kelas')->findOrFail($id);
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