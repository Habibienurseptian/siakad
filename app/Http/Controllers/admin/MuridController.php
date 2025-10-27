<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Murid;
use App\Models\Sekolah;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class MuridController extends Controller
{
    // Tampilkan data murid
    public function index(Request $request)
    {
        $search = $request->input('search', []);
        $sekolahs = Sekolah::all();
        $murids = [];

        foreach ($sekolahs as $sekolah) {
            $query = Murid::with(['user', 'sekolah', 'kelas'])
                ->where('sekolah_id', $sekolah->id);

            if (!empty($search[$sekolah->id])) {
                $term = $search[$sekolah->id];
                $query->where(function ($q) use ($term) {
                    $q->where('nomor_induk', 'like', "%{$term}%")
                      ->orWhereHas('user', function ($q) use ($term) {
                          $q->where('name', 'like', "%{$term}%");
                      })
                      ->orWhereHas('kelas', function ($q) use ($term) {
                          $q->where('nama_kelas', 'like', "%{$term}%");
                      });
                });
            }

            $paginator = $query->orderBy(
                Kelas::select('nama_kelas')
                    ->whereColumn('kelas.id', 'murids.kelas_id')
            )
            ->orderBy('nomor_induk')
            ->paginate(25, ['*'], 'page_' . $sekolah->id);

            $paginator->appends(['search' => $search]);
            $murids[$sekolah->id] = $paginator;
        }

        return view('admin.murid.index', compact('murids', 'sekolahs', 'search'));
    }

    // Simpan akun murid baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nomor_induk' => 'required|string|max:50|unique:murids,nomor_induk',
            'kelas_id' => 'required|exists:kelas,id',
            'password' => 'required|string|min:8',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'phone' => 'nullable|string|max:25',
            'telepon_orangtua' => 'nullable|string|max:25',
        ]);

        // Simpan user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'murid',
        ]);

        // Simpan murid
        Murid::create([
            'user_id' => $user->id,
            'nomor_induk' => $request->nomor_induk,
            'kelas_id' => $request->kelas_id,
            'sekolah_id' => $request->sekolah_id,
            'phone' => $request->phone,
            'telepon_orangtua' => $request->telepon_orangtua,
        ]);

        return redirect()->route('admin.murid.index')->with('success', 'Akun murid berhasil ditambahkan!');
    }

    // Detail murid
    public function show($id)
    {
        $murid = Murid::with(['user', 'sekolah', 'kelas'])->findOrFail($id);
        $sekolah = Sekolah::with('kelas')->findOrFail($murid->sekolah_id);
        return view('admin.murid.show', compact('murid', 'sekolah'));
    }

    // Edit murid
    public function edit($id)
    {
        $murid = Murid::with(['user', 'sekolah', 'kelas'])->findOrFail($id);
        $sekolah = $murid->sekolah;
        $kelasList = $sekolah ? $sekolah->kelas : collect();
        $sekolahs = Sekolah::all();

        return view('admin.murid.edit', compact('murid', 'sekolah', 'kelasList', 'sekolahs'));
    }

    // Update murid
    public function update(Request $request, $id)
    {
        $murid = Murid::with(['user', 'sekolah'])->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $murid->user->id,
            'nomor_induk' => 'required|string|max:50|unique:murids,nomor_induk,' . $murid->id,
            'kelas_id' => 'required|exists:kelas,id',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'phone' => 'nullable|string|max:25',
            'telepon_orangtua' => 'nullable|string|max:25',
            'password' => 'nullable|string|min:8',
        ]);

        // Update user
        $murid->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $murid->user->password,
        ]);

        // Update murid
        $murid->update([
            'nomor_induk' => $request->nomor_induk,
            'kelas_id' => $request->kelas_id,
            'sekolah_id' => $request->sekolah_id,
            'phone' => $request->phone,
            'telepon_orangtua' => $request->telepon_orangtua,
        ]);

        return redirect()->route('admin.murid.index')->with('success', 'Data murid berhasil diupdate!');
    }

    // Hapus murid
    public function destroy($id)
    {
        $murid = Murid::findOrFail($id);

        if ($murid->user) {
            $murid->user->delete();
        }

        $murid->delete();

        return redirect()->route('admin.murid.index')->with('success', 'Data murid berhasil dihapus!');
    }
}
