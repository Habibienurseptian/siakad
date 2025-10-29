<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // Tampilkan semua guru
    public function index(Request $request)
    {
        $search = $request->input('search', []); // Default to an empty array
        $sekolahs = Sekolah::all();
        $gurus = [];

        foreach ($sekolahs as $sekolah) {
            $query = Guru::with(['user', 'sekolah'])
                ->where('sekolah_id', $sekolah->id);

            if (!empty($search[$sekolah->id])) {
                $query->where(function ($q) use ($search, $sekolah) {
                    $q->where('nip', 'like', "%{$search[$sekolah->id]}%")
                      ->orWhereHas('user', function ($q) use ($search, $sekolah) {
                          $q->where('name', 'like', "%{$search[$sekolah->id]}%");
                      });
                });
            }

            $gurus[$sekolah->id] = $query->orderBy('nip')
                ->orderBy(User::select('name')->whereColumn('users.id', 'gurus.user_id'))
                ->paginate(25, ['*'], 'page_guru_' . $sekolah->id);
        }

        return view('admin.guru.index', [
            'gurus' => $gurus,
            'sekolahs' => $sekolahs,
            'search' => $search,
        ]);
    }

    // Simpan guru baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|unique:gurus,nip',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'phone' => 'nullable|string|max:25',
        ], [
            'nip.unique' => 'Nomor Induk Pegawai (NIP) sudah digunakan. Harap gunakan NIP lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'sekolah_id' => $request->sekolah_id,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    // Detail guru
    public function show($id)
    {
        $guru = Guru::with(['user', 'sekolah'])->findOrFail($id);
        return view('admin.guru.show', compact('guru'));
    }

    // Form edit guru
    public function edit($id)
    {
        $guru = Guru::with(['user', 'sekolah'])->findOrFail($id);
        $sekolahs = Sekolah::all();
        return view('admin.guru.edit', compact('guru', 'sekolahs'));
    }

    // Update data guru
    public function update(Request $request, $id)
    {
        $guru = Guru::with(['user', 'sekolah'])->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->user->id,
            'nip' => 'required|string|unique:gurus,nip,' . $guru->id,
            'sekolah_id' => 'required|exists:sekolahs,id',
            'phone' => 'nullable|string|max:25',
            'password' => 'nullable|string|min:8',
        ], [
            'nip.unique' => 'Nomor Induk Pegawai (NIP) sudah digunakan. Harap gunakan NIP lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        ]);

        $guru->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $guru->user->password,
        ]);

        $guru->update([
            'nip' => $request->nip,
            'sekolah_id' => $request->sekolah_id,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diupdate!');
    }

    // Hapus guru
    public function destroy($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        if($guru->user) {
            $guru->user->delete();
        }
        $guru->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|string',
        ]);

        $ids = explode(',', $request->ids);

        try {
            \DB::beginTransaction();

            $gurus = Guru::whereIn('id', $ids)->get();
            foreach ($gurus as $guru) {
                if ($guru->user) {
                    $guru->user->delete();
                }
                $guru->delete();
            }

            \DB::commit();
            return redirect()->route('admin.guru.index')->with('success', count($gurus) . ' data guru berhasil dihapus!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('admin.guru.index')->with('error', 'Gagal menghapus data guru: ' . $e->getMessage());
        }
}

}
