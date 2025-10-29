<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Models\Murid;
use App\Models\Nilai;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $guruNama = auth()->user()->name;
        $jadwalGuru = JadwalPelajaran::with('kelas')->where('guru', $guruNama)->get();

        $mapelSelected = strtoupper($request->mapel ?? '');
        $kelasIdSelected = $request->kelas_id ?? null;

        // Ambil daftar mapel unik
        $mapelList = collect();
        if ($kelasIdSelected) {
            $mapelList = $jadwalGuru
                ->filter(fn($j) => $j->kelas_id == $kelasIdSelected)
                ->pluck('mapel')
                ->unique(fn($m) => strtoupper($m));
        } else {
            $mapelList = $jadwalGuru
                ->pluck('mapel')
                ->unique(fn($m) => strtoupper($m));
        }

        // Ambil daftar kelas unik berdasarkan ID
        $kelasList = collect();
        if ($mapelSelected) {
            $kelasIds = $jadwalGuru
                ->filter(fn($j) => strtoupper($j->mapel) === $mapelSelected)
                ->pluck('kelas_id')
                ->unique();
            $kelasList = Kelas::whereIn('id', $kelasIds)->get();
        } else {
            $kelasIds = $jadwalGuru->pluck('kelas_id')->unique();
            $kelasList = Kelas::whereIn('id', $kelasIds)->get();
        }

        $muridList = collect();
        $muridSudahDinilai = collect();
        $nilaiDraft = collect();
        $hasUngraded = false;
        $kelasSelected = null;

        if ($mapelSelected && $kelasIdSelected) {
            // Pastikan guru mengajar kombinasi ini
            $this->authorizeByMapelKelas($mapelSelected, $kelasIdSelected);

            $kelasSelected = Kelas::find($kelasIdSelected);

            $muridList = Murid::where('kelas_id', $kelasIdSelected)->get();
            $muridSudahDinilai = Nilai::whereRaw('UPPER(mapel) = ?', [$mapelSelected])
                ->where('kelas_id', $kelasIdSelected)
                ->get();

            $nilaiDraft = Nilai::whereRaw('UPPER(mapel) = ?', [$mapelSelected])
                ->where('kelas_id', $kelasIdSelected)
                ->where('status', 'draft')
                ->get();

            $muridList = $muridList->map(function ($murid) use ($muridSudahDinilai, &$hasUngraded) {
                $murid->sudahDinilai = $muridSudahDinilai->where('murid_id', $murid->id)->first();
                if (!$murid->sudahDinilai) {
                    $hasUngraded = true;
                }
                return $murid;
            });
        }

        return view('guru.nilai.index', compact(
            'mapelList',
            'kelasList',
            'muridList',
            'muridSudahDinilai',
            'mapelSelected',
            'kelasIdSelected',
            'kelasSelected',
            'nilaiDraft',
            'hasUngraded'
        ));
    }

    protected function authorizeByMapelKelas($mapel, $kelasId)
    {
        $guruNama = auth()->user()->name;
        $exists = JadwalPelajaran::whereRaw('UPPER(mapel) = ?', [strtoupper($mapel)])
            ->where('kelas_id', $kelasId)
            ->where('guru', $guruNama)
            ->exists();

        if (!$exists) {
            abort(403, 'Anda tidak memiliki izin untuk melihat atau mengubah nilai untuk mapel/kelas ini.');
        }
    }

    protected function authorizeByNilai($nilai)
    {
        $guruNama = auth()->user()->name;
        $allowed = false;

        if ($nilai->jadwal_id) {
            $allowed = JadwalPelajaran::where('id', $nilai->jadwal_id)
                ->where('guru', $guruNama)
                ->exists();
        }

        if (!$allowed) {
            // fallback: cocokkan berdasarkan mapel dan kelas_id
            $allowed = JadwalPelajaran::whereRaw('UPPER(mapel) = ?', [strtoupper($nilai->mapel)])
                ->where('kelas_id', $nilai->kelas_id)
                ->where('guru', $guruNama)
                ->exists();
        }

        if (!$allowed) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah nilai ini.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'mapel' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'nilai_tugas' => 'required|array',
            'nilai_uts' => 'required|array',
            'nilai_uas' => 'required|array',
        ]);

        $mapel = strtoupper($request->mapel);
        $kelasId = $request->kelas_id;

        $this->authorizeByMapelKelas($mapel, $kelasId);

        $jadwal = JadwalPelajaran::whereRaw('UPPER(mapel) = ?', [$mapel])
            ->where('kelas_id', $kelasId)
            ->where('guru', auth()->user()->name)
            ->first();

        $jadwalId = $jadwal ? $jadwal->id : null;

        foreach ($request->nilai_tugas as $muridId => $nilaiTugas) {
            $nilaiUts = $request->nilai_uts[$muridId] ?? null;
            $nilaiUas = $request->nilai_uas[$muridId] ?? null;

            Nilai::updateOrCreate(
                [
                    'murid_id' => $muridId,
                    'kelas_id' => $kelasId,
                    'mapel' => $mapel,
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

        return redirect()->route('guru.nilai.index', ['mapel' => $mapel, 'kelas_id' => $kelasId])
            ->with('success', 'Nilai berhasil disimpan sebagai draft!');
    }

    public function publish(Request $request)
    {
        $request->validate([
            'mapel' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $mapel = strtoupper($request->mapel);
        $kelasId = $request->kelas_id;

        $this->authorizeByMapelKelas($mapel, $kelasId);

        $nilaiDraft = Nilai::whereRaw('UPPER(mapel) = ?', [$mapel])
            ->where('kelas_id', $kelasId)
            ->where('status', 'draft')
            ->get();

        foreach ($nilaiDraft as $nilai) {
            $nilai->status = 'publish';
            $nilai->save();
        }

        return redirect()->route('guru.nilai.index', ['mapel' => $mapel, 'kelas_id' => $kelasId])
            ->with('success', 'Nilai berhasil dipublikasi!');
    }

    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $this->authorizeByNilai($nilai);
        $murid = $nilai->murid;

        return view('guru.nilai.edit', compact('nilai', 'murid'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai_tugas' => 'required|integer|min:0|max:100',
            'nilai_uts' => 'required|integer|min:0|max:100',
            'nilai_uas' => 'required|integer|min:0|max:100',
        ]);

        $nilai = Nilai::findOrFail($id);
        $this->authorizeByNilai($nilai);

        $nilai->nilai_tugas = $request->nilai_tugas;
        $nilai->nilai_uts = $request->nilai_uts;
        $nilai->nilai_uas = $request->nilai_uas;
        $nilai->save();

        return redirect()->route('guru.nilai.index', [
            'mapel' => strtoupper($nilai->mapel),
            'kelas_id' => $nilai->kelas_id
        ])->with('success', 'Nilai berhasil diupdate!');
    }
}