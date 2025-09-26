<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Models\Murid;
use App\Models\Nilai;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $guruNama = auth()->user()->name;
        $mapelList = JadwalPelajaran::where('guru', $guruNama)->pluck('mapel')->unique();
        $kelasList = JadwalPelajaran::where('guru', $guruNama)->pluck('kelas')->unique();
        $muridList = collect();
        $muridSudahDinilai = collect();
        $mapelSelected = $request->mapel;
        $kelasSelected = $request->kelas;
        if ($mapelSelected && $kelasSelected) {
            $muridList = Murid::where('kelas', $kelasSelected)->get();
            $muridSudahDinilai = \App\Models\Nilai::where('mapel', $mapelSelected)->where('kelas', $kelasSelected)->get();
        }
        return view('guru.nilai.index', compact('mapelList', 'kelasList', 'muridList', 'muridSudahDinilai', 'mapelSelected', 'kelasSelected'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mapel' => 'required',
            'kelas' => 'required',
            'nilai_tugas' => 'required|array',
            'nilai_uts' => 'required|array',
            'nilai_uas' => 'required|array',
        ]);
        foreach ($request->nilai_tugas as $muridId => $nilaiTugas) {
            $nilaiUts = $request->nilai_uts[$muridId] ?? null;
            $nilaiUas = $request->nilai_uas[$muridId] ?? null;
            $jadwal = \App\Models\JadwalPelajaran::where('mapel', $request->mapel)
                ->where('kelas', $request->kelas)
                ->where('guru', auth()->user()->name)
                ->first();
            $jadwalId = $jadwal ? $jadwal->id : null;
            \App\Models\Nilai::updateOrCreate(
                [
                    'murid_id' => $muridId,
                    'kelas' => $request->kelas,
                    'mapel' => $request->mapel,
                ],
                [
                    'jadwal_id' => $jadwalId,
                    'nilai_tugas' => $nilaiTugas,
                    'nilai_uts' => $nilaiUts,
                    'nilai_uas' => $nilaiUas,
                    'status' => 'draft',
                ]
            );
        }
        return redirect()->route('guru.nilai.index', ['mapel' => $request->mapel, 'kelas' => $request->kelas])
            ->with('success', 'Nilai berhasil disimpan sebagai draft!');
    }

    public function publish(Request $request)
    {
        $request->validate([
            'mapel' => 'required',
            'kelas' => 'required',
        ]);
        $nilaiDraft = \App\Models\Nilai::where('mapel', $request->mapel)
            ->where('kelas', $request->kelas)
            ->where('status', 'draft')
            ->get();
        foreach ($nilaiDraft as $nilai) {
            $nilai->status = 'publish';
            $nilai->save();
        }
        return redirect()->route('guru.nilai.index', ['mapel' => $request->mapel, 'kelas' => $request->kelas])
            ->with('success', 'Nilai berhasil dipublikasi!');
    }

    public function edit($id)
    {
        $nilai = \App\Models\Nilai::findOrFail($id);
        $murid = $nilai->murid;
        return view('guru.nilai.edit', compact('nilai', 'murid'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'nilai_tugas' => 'required|integer|min:0|max:100',
            'nilai_uts' => 'required|integer|min:0|max:100',
            'nilai_uas' => 'required|integer|min:0|max:100',
        ]);
        $nilai = \App\Models\Nilai::findOrFail($id);
        $nilai->nilai_tugas = $request->nilai_tugas;
        $nilai->nilai_uts = $request->nilai_uts;
        $nilai->nilai_uas = $request->nilai_uas;
        $nilai->save();
        return redirect()->route('guru.nilai.index', ['mapel' => $nilai->mapel, 'kelas' => $nilai->kelas])
            ->with('success', 'Nilai berhasil diupdate!');
    }
}
