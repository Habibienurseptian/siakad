<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolahs = Sekolah::all();
        return view('admin.sekolah.index', compact('sekolahs'));
    }

    public function create()
    {
        return view('admin.sekolah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'kepala_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|max:20|unique:sekolahs,npsn',
        ]
        , [
            'npsn.unique' => 'NPSN sudah terdaftar, silakan gunakan NPSN lain.',
        ]);
        Sekolah::create($request->only(['nama', 'alamat', 'kepala_sekolah', 'npsn']));
        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        return view('admin.sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'kepala_sekolah' => 'required|string|max:255',
            'npsn' => 'required|string|max:20|unique:sekolahs,npsn,' . $sekolah->id,
        ], [
            'npsn.unique' => 'NPSN sudah terdaftar, silakan gunakan NPSN lain.',
        ]);
        $sekolah->update($request->only(['nama', 'alamat', 'kepala_sekolah', 'npsn']));
        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil diupdate!');
    }

    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->delete();
        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil dihapus!');
    }

    public function show($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $classes = \App\Models\Kelas::where('sekolah_id', $sekolah->id)
            ->orderBy('nama_kelas')
            ->get();

        $classCount = $classes->count();

        return view('admin.sekolah.show', compact('sekolah', 'classes', 'classCount',));
    }

    public function storeKelas(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'wali_kelas' => 'nullable|string|max:100',
            'jumlah_siswa' => 'nullable|integer|min:0',
        ]);

        // Simpan ke tabel 'kelas'
        \App\Models\Kelas::create([
            'sekolah_id' => $sekolah->id,
            'nama_kelas' => $request->nama_kelas,
            'wali_kelas' => $request->wali_kelas,
            'jumlah_siswa' => $request->jumlah_siswa,
        ]);

        return redirect()->route('admin.sekolah.show', $sekolah->id)
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function updateKelas(Request $request, $id, $kelasId)
    {
        $request->validate(['nama_kelas' => 'required|string|max:255']);

        $kelasModel = \App\Models\Kelas::where('sekolah_id', $id)
            ->where('id', $kelasId)
            ->firstOrFail();

        $kelasModel->update([
            'nama_kelas' => $request->nama_kelas,
            'wali_kelas' => $request->wali_kelas,
            'jumlah_siswa' => $request->jumlah_siswa,
        ]);

        return redirect()->route('admin.sekolah.show', $id)
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroyKelas($id, $kelasId)
    {
        $kelasModel = \App\Models\Kelas::where('sekolah_id', $id)
            ->where('nama_kelas', $kelasId)
            ->firstOrFail();

        $kelasModel->delete();

        return redirect()->route('admin.sekolah.show', $id)->with('success', 'Kelas berhasil dihapus.');
    }


}
