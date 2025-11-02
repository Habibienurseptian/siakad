<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Murid;
use App\Models\Sekolah;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MuridController extends Controller
{
    /** 
     * Tampilkan daftar murid dengan filter per sekolah 
     */
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
                        ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$term}%"))
                        ->orWhereHas('kelas', fn($k) => $k->where('nama_kelas', 'like', "%{$term}%"));
                });
            }

            $murids[$sekolah->id] = $query
                ->orderBy(
                    Kelas::select('nama_kelas')->whereColumn('kelas.id', 'murids.kelas_id')
                )
                ->orderBy('nomor_induk')
                ->paginate(25, ['*'], 'page_' . $sekolah->id)
                ->appends(['search' => $search]);
        }

        return view('admin.murid.index', compact('murids', 'sekolahs', 'search'));
    }

    /**
     * Simpan data murid baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nomor_induk' => 'required|string|max:50|unique:murids,nomor_induk',
            'kelas_id' => 'required|exists:kelas,id',
            'password' => 'required|string|min:8',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'phone' => 'nullable|string|max:25',
            'telepon_orangtua' => 'nullable|string|max:25',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'murid',
            ]);

            $profileImagePath = null;
            if ($request->hasFile('profile_image')) {
                $profileImagePath = $request->file('profile_image')->store('profile_image', 'public');
            }

            Murid::create([
                'user_id' => $user->id,
                'nomor_induk' => $validated['nomor_induk'],
                'kelas_id' => $validated['kelas_id'],
                'sekolah_id' => $validated['sekolah_id'],
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'telepon_orangtua' => $validated['telepon_orangtua'] ?? null,
                'profile_image' => $profileImagePath,
            ]);

            DB::commit();

            return redirect()->route('admin.murid.index')->with('success', 'Akun murid berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail murid
     */
    public function show($id)
    {
        $murid = Murid::with(['user', 'sekolah', 'kelas'])->findOrFail($id);
        $sekolah = Sekolah::with('kelas')->findOrFail($murid->sekolah_id);
        return view('admin.murid.show', compact('murid', 'sekolah'));
    }

    /**
     * Edit data murid
     */
    public function edit($id)
    {
        $murid = Murid::with(['user', 'sekolah', 'kelas'])->findOrFail($id);
        $sekolah = $murid->sekolah;
        $kelasList = $sekolah ? $sekolah->kelas : collect();
        $sekolahs = Sekolah::all();

        return view('admin.murid.edit', compact('murid', 'sekolah', 'kelasList', 'sekolahs'));
    }

    /**
     * Update data murid
     */
    public function update(Request $request, $id)
    {
        $murid = Murid::with('user')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $murid->user->id,
            'nomor_induk' => 'required|string|max:50|unique:murids,nomor_induk,' . $murid->id,
            'kelas_id' => 'required|exists:kelas,id',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'password' => 'nullable|string|min:8',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Update user
            $murid->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $request->filled('password')
                    ? Hash::make($validated['password'])
                    : $murid->user->password,
            ]);

            // Hapus gambar lama jika ada upload baru
            if ($request->hasFile('profile_image')) {
                if ($murid->profile_image && Storage::disk('public')->exists($murid->profile_image)) {
                    Storage::disk('public')->delete($murid->profile_image);
                }
                $murid->profile_image = $request->file('profile_image')->store('profile_image', 'public');
            }

            // Jika klik hapus foto
            if ($request->input('remove_image') == '1') {
                if ($murid->profile_image && Storage::disk('public')->exists($murid->profile_image)) {
                    Storage::disk('public')->delete($murid->profile_image);
                }
                $murid->profile_image = null;
            }

            // Update data murid
            $murid->update([
                'nomor_induk' => $validated['nomor_induk'],
                'kelas_id' => $validated['kelas_id'],
                'sekolah_id' => $validated['sekolah_id'],
                'jenis_kelamin' => $request->jenis_kelamin,
                'phone' => $request->phone,
                'telepon_orangtua' => $request->telepon_orangtua,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'warga_negara' => $request->warga_negara,
                'alamat' => $request->alamat,
                'kode_pos' => $request->kode_pos,
                'nama_orangtua' => $request->nama_orangtua,
                'tempat_lahir_orangtua' => $request->tempat_lahir_orangtua,
                'tanggal_lahir_orangtua' => $request->tanggal_lahir_orangtua,
                'profile_image' => $murid->profile_image,
            ]);

            DB::commit();
            return redirect()->route('admin.murid.index')->with('success', 'Data murid berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate data murid: ' . $e->getMessage());
        }
    }

    /**
     * Hapus satu murid
     */
    public function destroy($id)
    {
        $murid = Murid::findOrFail($id);

        if ($murid->profile_image && Storage::disk('public')->exists($murid->profile_image)) {
            Storage::disk('public')->delete($murid->profile_image);
        }

        if ($murid->user) {
            $murid->user->delete();
        }

        $murid->delete();

        return redirect()->route('admin.murid.index')->with('success', 'Data murid berhasil dihapus!');
    }

    /**
     * Hapus banyak murid sekaligus
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
        ]);

        $ids = explode(',', $request->ids);

        try {
            DB::beginTransaction();

            $murids = Murid::whereIn('id', $ids)->get();

            foreach ($murids as $murid) {
                if ($murid->profile_image && Storage::disk('public')->exists($murid->profile_image)) {
                    Storage::disk('public')->delete($murid->profile_image);
                }
                if ($murid->user) {
                    $murid->user->delete();
                }
                $murid->delete();
            }

            DB::commit();
            return redirect()->route('admin.murid.index')
                ->with('success', count($murids) . ' data murid berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.murid.index')
                ->with('error', 'Gagal menghapus data murid: ' . $e->getMessage());
        }
    }
}
