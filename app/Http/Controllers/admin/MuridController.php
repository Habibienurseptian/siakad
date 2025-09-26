<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Murid;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Hash;

class MuridController extends Controller
{
    // Tampilkan data murid
    public function index()
    {
        $sekolahs = Sekolah::all();
        $murids = [];
        foreach ($sekolahs as $sekolah) {
            $murids[$sekolah->id] = Murid::with(['user', 'sekolah'])
                ->where('sekolah_id', $sekolah->id)
                ->orderBy('kelas')
                ->orderBy('nomor_induk')
                ->orderBy(User::select('name')->whereColumn('users.id', 'murids.user_id'))
                ->paginate(25, ['*'], 'page_' . $sekolah->id);
        }
        return view('admin.murid.index', compact('murids', 'sekolahs'));
    }

    // Simpan akun murid baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nomor_induk' => 'required|string|max:50|unique:murids,nomor_induk',
            'kelas' => 'required|string|max:50',
            'password' => 'required|string|min:6',
            'sekolah_id' => 'required|exists:sekolahs,id',
        ], [
            'nomor_induk.unique' => 'Nomor Induk sudah digunakan, silakan gunakan yang lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        ]);

        // Simpan ke tabel users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'murid',
        ]);

        // Simpan ke tabel murids
        Murid::create([
            'user_id' => $user->id,
            'nomor_induk' => $request->nomor_induk,
            'kelas' => $request->kelas,
            'sekolah_id' => $request->sekolah_id,
        ]);

        return redirect()->route('admin.murid.index')->with('success', 'Akun murid berhasil ditambahkan!');
    }

    // Tampilkan detail murid
    public function show($id)
    {
        $murid = Murid::with(['user', 'sekolah'])->findOrFail($id);
        return view('admin.murid.show', compact('murid'));
    }

    // Tampilkan form edit murid
    public function edit($id)
    {
        $murid = Murid::with(['user', 'sekolah'])->findOrFail($id);
        $sekolahs = Sekolah::all();
        return view('admin.murid.edit', compact('murid', 'sekolahs'));
    }

    // Update data murid
    public function update(Request $request, $id)
    {
        $murid = Murid::with(['user', 'sekolah'])->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $murid->user->id,
            'nomor_induk' => 'required|string|max:50|unique:murids,nomor_induk,' . $murid->id,
            'kelas' => 'required|string|max:50',
            'sekolah_id' => 'required|exists:sekolahs,id',
        ], [
            'nomor_induk.unique' => 'Nomor Induk sudah digunakan oleh murid lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        ]);

        // Update data user
        $murid->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update data murid
        $murid->update([
            'nomor_induk' => $request->nomor_induk,
            'kelas' => $request->kelas,
            'sekolah_id' => $request->sekolah_id,
        ]);

        return redirect()->route('admin.murid.index')->with('success', 'Data murid berhasil diupdate!');
    }

    // Hapus data murid
    public function destroy($id)
    {
        $murid = Murid::findOrFail($id);

        // Hapus user yang terkait
        if ($murid->user) {
            $murid->user->delete();
        }

        // Hapus murid
        $murid->delete();

        return redirect()->route('admin.murid.index')->with('success', 'Data murid berhasil dihapus!');
    }
}
