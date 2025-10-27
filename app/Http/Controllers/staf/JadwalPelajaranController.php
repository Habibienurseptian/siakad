<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Models\Sekolah;
use App\Models\Guru;
use App\Models\Staf;
use App\Models\Murid;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        $staf = Staf::where('user_id', auth()->id())->first();
        $sekolahs = collect();
        $gurus = collect();

        if ($staf && $staf->sekolah_id) {
            $sekolah = Sekolah::with('jadwalPelajaran')->find($staf->sekolah_id);

            if ($sekolah) {
                $jadwalByKelas = $sekolah->jadwalPelajaran->groupBy(function ($jadwal) {
                    return $jadwal->kelas ? $jadwal->kelas->nama_kelas : 'Tidak Diketahui';
                });

                $jadwalByKelas = $jadwalByKelas->sortKeys();

                // Group berdasarkan hari di dalam setiap kelas
                foreach ($jadwalByKelas as $kelas => $jadwals) {
                    $jadwalByKelas[$kelas] = $jadwals->groupBy('hari');
                }

                $sekolah->jadwalByKelas = $jadwalByKelas;
                $sekolahs = collect([$sekolah]);

                $gurus = Guru::where('sekolah_id', $staf->sekolah_id)->get();
            }
        }

        return view('staf.jadwal.index', compact('sekolahs', 'gurus'));
    }

    public function create()
    {
        $staf = Staf::where('user_id', auth()->id())->first();
        $gurus = collect();

        if ($staf && $staf->sekolah_id) {
            $gurus = Guru::where('sekolah_id', $staf->sekolah_id)->get();
        }

        return view('staf.jadwal.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'mapel' => 'required',
            'guru' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $mapelNormalized = strtoupper(trim($request->mapel));
        $kelasId = $request->kelas_id;

        // Cek unik (case-insensitive): sekolah + mapel + kelas_id
        $existing = JadwalPelajaran::where('sekolah_id', $request->sekolah_id)
            ->where('kelas_id', $kelasId)
            ->whereRaw('UPPER(TRIM(mapel)) = ?', [$mapelNormalized])
            ->first();

        if ($existing && $existing->guru !== $request->guru) {
            return back()
                ->withErrors(['mapel' => 'Jadwal untuk mata pelajaran dan kelas ini sudah ada dengan guru lain.'])
                ->withInput();
        }

        // Cek tabrakan jam
        $conflict = JadwalPelajaran::where('sekolah_id', $request->sekolah_id)
            ->where('guru', $request->guru)
            ->where('hari', $request->hari)
            ->where('jam_mulai', '<', $request->jam_selesai)
            ->where('jam_selesai', '>', $request->jam_mulai)
            ->first();

        if ($conflict) {
            return back()
                ->withErrors(['guru' => 'Guru sudah memiliki jadwal yang bertabrakan pada hari dan jam tersebut.'])
                ->withInput();
        }

        JadwalPelajaran::create([
            'sekolah_id' => $request->sekolah_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'mapel' => $mapelNormalized,
            'guru' => $request->guru,
            'kelas_id' => $kelasId,
        ]);

        return redirect()->route('staf.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }


    public function edit($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $staf = Staf::where('user_id', auth()->id())->first();
        $gurus = collect();
        $kelasList = collect();

        if ($staf && $staf->sekolah_id) {
            $gurus = Guru::where('sekolah_id', $staf->sekolah_id)->get();
            $kelasList = \App\Models\Kelas::where('sekolah_id', $staf->sekolah_id)->get();
        }

        return view('staf.jadwal.edit', compact('jadwal', 'gurus', 'kelasList'));
    }

   public function update(Request $request, $id)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'mapel' => 'required',
            'guru' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $jadwal = JadwalPelajaran::findOrFail($id);
        $mapelNormalized = strtoupper(trim($request->mapel));
        $kelasId = $request->kelas_id;

        // Cek duplikasi: sekolah + mapel + kelas_id
        $existing = JadwalPelajaran::where('sekolah_id', $request->sekolah_id)
            ->where('kelas_id', $kelasId)
            ->whereRaw('UPPER(TRIM(mapel)) = ?', [$mapelNormalized])
            ->where('id', '!=', $jadwal->id)
            ->first();

        if ($existing && $existing->guru !== $request->guru) {
            return back()
                ->withErrors(['mapel' => 'Jadwal untuk mata pelajaran dan kelas ini sudah ada dengan guru lain.'])
                ->withInput();
        }

        $jadwal->update([
            'sekolah_id' => $request->sekolah_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'mapel' => $mapelNormalized,
            'guru' => $request->guru,
            'kelas_id' => $kelasId, 
        ]);

        return redirect()->route('staf.jadwal.index')->with('success', 'Jadwal berhasil diupdate');
    }


    public function destroy($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }
}
