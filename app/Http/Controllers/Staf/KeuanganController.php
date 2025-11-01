<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;

class KeuanganController extends Controller
{
    public function index()
    {
        $staf = \App\Models\Staf::where('user_id', auth()->id())->first();
        $sekolah = null;
        $pemasukanTagihan = collect();
        $pemasukanManual = collect();
        $pengeluaran = collect();

        if ($staf && $staf->sekolah_id) {
            $sekolah = \App\Models\Sekolah::find($staf->sekolah_id);

            // Pemasukan dari tagihan
            $pemasukanTagihan = Tagihan::with('murid.user')
                ->where('status', 'lunas')
                ->whereHas('murid', function($q) use ($staf) {
                    $q->where('sekolah_id', $staf->sekolah_id);
                })
                ->orderBy('updated_at', 'desc')
                ->get();

            // Pemasukan manual
            $pemasukanManual = \App\Models\Keuangan::where('jenis', 'pemasukan')
                ->where('sekolah_id', $staf->sekolah_id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            // Pengeluaran
            $pengeluaran = \App\Models\Keuangan::where('jenis', 'pengeluaran')
                ->where('sekolah_id', $staf->sekolah_id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc')
                ->get();
        }

        // Gabungkan pemasukan manual dan tagihan
        $pemasukan = $pemasukanManual->map(function($item) {
            $item->__tanggal_sort = $item->tanggal;
            $item->__id_sort = $item->id;
            return $item;
        })->concat(
            $pemasukanTagihan->map(function($item) {
                $item->__tanggal_sort = $item->updated_at;
                $item->__id_sort = $item->id;
                return $item;
            })
        )->sortByDesc(function($item) {
            return [$item->__tanggal_sort, $item->__id_sort];
        })->values();

        // Hitung total pemasukan
        $totalPemasukan = $pemasukan->sum(function($item) {
            // Jika pemasukan manual
            if (isset($item->jumlah)) {
                return $item->jumlah;
            }
            // Jika pemasukan dari tagihan
            return ($item->spp ?? 0)
                + ($item->spi ?? 0)
                + ($item->tagihan_kegiatan ?? 0)
                + ($item->tagihan_semester_ganjil ?? 0)
                + ($item->tagihan_semester_genap ?? 0)
                + ($item->haul ?? 0);
        });

        // Total pengeluaran
        $totalPengeluaran = $pengeluaran->sum(function($item) {
            return $item->jumlah ?? 0;
        });

        $totalKas = $totalPemasukan - $totalPengeluaran;
        $totalAll = $totalPemasukan + $totalPengeluaran;
        $persenPemasukan = $totalAll > 0 ? round(($totalPemasukan / $totalAll) * 100, 1) : 0;
        $persenPengeluaran = $totalAll > 0 ? round(($totalPengeluaran / $totalAll) * 100, 1) : 0;
        $persenKas = $totalAll > 0 ? round(($totalKas / $totalAll) * 100, 1) : 0;

        return view('staf.keuangan.index', [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalKas' => $totalKas,
            'persenPemasukan' => $persenPemasukan,
            'persenPengeluaran' => $persenPengeluaran,
            'persenKas' => $persenKas,
            'sekolah' => $sekolah,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:1',
        ]);
        $staf = \App\Models\Staf::where('user_id', auth()->id())->first();
        $data = $request->only(['tanggal', 'jenis', 'keterangan', 'jumlah']);
        $data['sekolah_id'] = $staf->sekolah_id ?? null;
        \App\Models\Keuangan::create($data);
        return redirect()->route('staf.keuangan.index')->with('success', 'Data keuangan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $keuangan = \App\Models\Keuangan::findOrFail($id);
        return view('staf.keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:1',
        ]);
        $staf = \App\Models\Staf::where('user_id', auth()->id())->first();
        $keuangan = \App\Models\Keuangan::findOrFail($id);
        $data = $request->only(['tanggal', 'jenis', 'keterangan', 'jumlah']);
        $data['sekolah_id'] = $staf->sekolah_id ?? null;
        $keuangan->update($data);
        return redirect()->route('staf.keuangan.index')->with('success', 'Data keuangan berhasil diupdate');
    }

    public function destroy($id)
    {
        $keuangan = \App\Models\Keuangan::findOrFail($id);
        $keuangan->delete();
        return redirect()->route('staf.keuangan.index')->with('success', 'Data keuangan berhasil dihapus');
    }
}
