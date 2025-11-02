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
        $search = $request->input('search', []); 
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
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
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
            'jenis_kelamin' => $request->jenis_kelamin, // Tambahkan ini
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
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan', // Tambahkan validasi
            'password' => 'nullable|string|min:8',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'warga_negara' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'status_marital' => 'nullable|in:menikah,belum menikah,cerai',
            'nama_orangtua' => 'nullable|string|max:255',
            'tempat_lahir_orangtua' => 'nullable|string|max:255',
            'tanggal_lahir_orangtua' => 'nullable|date',
        ], [
            'nip.unique' => 'Nomor Induk Pegawai (NIP) sudah digunakan. Harap gunakan NIP lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        ]);

        // Update user data
        $guru->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $guru->user->password,
        ]);

        // Update guru data
        $guru->update([
            'nip' => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin, // Tambahkan ini
            'sekolah_id' => $request->sekolah_id,
            'phone' => $request->phone,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warga_negara' => $request->warga_negara,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'status_marital' => $request->status_marital,
            'nama_orangtua' => $request->nama_orangtua,
            'tempat_lahir_orangtua' => $request->tempat_lahir_orangtua,
            'tanggal_lahir_orangtua' => $request->tanggal_lahir_orangtua,
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