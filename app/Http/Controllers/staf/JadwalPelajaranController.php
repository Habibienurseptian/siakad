<?php
namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Models\Sekolah;
use App\Models\Guru;

class JadwalPelajaranController extends Controller
{
	public function index()
	{
		$staf = \App\Models\Staf::where('user_id', auth()->id())->first();
		$sekolahs = collect();
		$gurus = collect();
		if ($staf && $staf->sekolah_id) {
			$sekolah = Sekolah::with('jadwalPelajaran')->find($staf->sekolah_id);
			if ($sekolah) {
				$sekolah->jadwalByKelas = $sekolah->jadwalPelajaran->groupBy('kelas');
				foreach ($sekolah->jadwalByKelas as $kelas => $jadwals) {
					$sekolah->jadwalByKelas[$kelas] = $jadwals->groupBy('hari');
				}
				$sekolahs = collect([$sekolah]);
				$gurus = \App\Models\Guru::where('sekolah_id', $staf->sekolah_id)->get();
			}
		}
		return view('staf.jadwal.index', compact('sekolahs', 'gurus'));
	}

	public function create()
	{
		$staf = \App\Models\Staf::where('user_id', auth()->id())->first();
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
			'kelas' => 'required',
		]);

		JadwalPelajaran::create([
			'sekolah_id' => $request->sekolah_id,
			'hari' => $request->hari,
			'jam_mulai' => $request->jam_mulai,
			'jam_selesai' => $request->jam_selesai,
			'mapel' => $request->mapel,
			'guru' => $request->guru,
			'kelas' => $request->kelas,
		]);

	return redirect()->route('staf.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
	}

	public function edit($id)
	{
		$jadwal = JadwalPelajaran::findOrFail($id);
		$staf = \App\Models\Staf::where('user_id', auth()->id())->first();
		$gurus = collect();
		if ($staf && $staf->sekolah_id) {
			$gurus = Guru::where('sekolah_id', $staf->sekolah_id)->get();
		}
		return view('staf.jadwal.edit', compact('jadwal', 'gurus'));
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
			'kelas' => 'required',
		]);

		$jadwal = JadwalPelajaran::findOrFail($id);
		$jadwal->update([
			'sekolah_id' => $request->sekolah_id,
			'hari' => $request->hari,
			'jam_mulai' => $request->jam_mulai,
			'jam_selesai' => $request->jam_selesai,
			'mapel' => $request->mapel,
			'guru' => $request->guru,
			'kelas' => $request->kelas,
		]);

	return redirect()->route('staf.jadwal.index')->with('success', 'Jadwal berhasil diupdate');
	}

	public function destroy($id)
	{
		$jadwal = JadwalPelajaran::findOrFail($id);
		$jadwal->delete();
		return redirect()->back()->with('success', 'Jadwal berhasil dihapus');
	}
}
