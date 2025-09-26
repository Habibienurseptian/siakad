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
    $gurus = \App\Models\User::where('role', 'guru')->orderBy('name')->get();
    $murids = \App\Models\User::where('role', 'murid')->orderBy('name')->get();
    return view('admin.sekolah.show', compact('sekolah', 'gurus', 'murids'));
    }
}
