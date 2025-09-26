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
    public function index()
    {
        $sekolahs = Sekolah::all();
            $gurus = [];
            foreach ($sekolahs as $sekolah) {
                $gurus[$sekolah->id] = Guru::with(['user', 'sekolah'])
                    ->where('sekolah_id', $sekolah->id)
                    ->orderBy('nip')
                    ->orderBy(User::select('name')->whereColumn('users.id', 'gurus.user_id'))
                    ->paginate(25, ['*'], 'page_guru_' . $sekolah->id);
            }
            return view('admin.guru.index', compact('gurus', 'sekolahs'));
    }

    // Simpan guru baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nip' => 'required|string|unique:gurus,nip',
            'sekolah_id' => 'required|exists:sekolahs,id',
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
        ], [
            'nip.unique' => 'Nomor Induk Pegawai (NIP) sudah digunakan. Harap gunakan NIP lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        ]);

        $guru->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $guru->update([
            'nip' => $request->nip,
            'sekolah_id' => $request->sekolah_id,
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
}
