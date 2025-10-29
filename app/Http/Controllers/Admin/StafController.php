<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staf;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StafController extends Controller
{
    public function index()
    {
        $sekolahs = Sekolah::all();
        $stafs = [];
        foreach ($sekolahs as $sekolah) {
            $stafs[$sekolah->id] = Staf::with(['user', 'sekolah'])
                ->where('sekolah_id', $sekolah->id)
                ->orderBy('nip')
                ->orderBy(User::select('name')->whereColumn('users.id', 'stafs.user_id'))
                ->paginate(25, ['*'], 'page_staf_' . $sekolah->id);
        }
        return view('admin.staf.index', compact('stafs', 'sekolahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nip' => 'required|string|unique:stafs,nip',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'bidang' => 'nullable|string|max:100',
        ], [
            'nip.unique' => 'Nomor Induk Pegawai (NIP) sudah digunakan. Harap gunakan NIP lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staf',
        ]);
        Staf::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'sekolah_id' => $request->sekolah_id,
            'bidang' => $request->bidang,
        ]);
        return redirect()->route('admin.staf.index')->with('success', 'Data staf berhasil ditambahkan!');
    }

    public function show($id)
    {
        $staf = Staf::with(['user', 'sekolah'])->findOrFail($id);
        $sekolahs = Sekolah::orderBy('nama')->get();
        return view('admin.staf.show', compact('staf', 'sekolahs'));
    }

    public function edit($id)
    {
        $staf = Staf::with(['user', 'sekolah'])->findOrFail($id);
        $sekolahs = Sekolah::all();
        return view('admin.staf.edit', compact('staf', 'sekolahs'));
    }

    public function update(Request $request, $id)
    {
        $staf = Staf::with(['user', 'sekolah'])->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staf->user->id,
            'nip' => 'required|string|unique:stafs,nip,' . $staf->id,
            'sekolah_id' => 'required|exists:sekolahs,id',
            'bidang' => 'nullable|string|max:100',
        ], [
            'nip.unique' => 'Nomor Induk Pegawai (NIP) sudah digunakan. Harap gunakan NIP lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        ]);
        
        $staf->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $staf->update([
            'nip' => $request->nip,
            'sekolah_id' => $request->sekolah_id,
            'bidang' => $request->bidang,
        ]);
        return redirect()->route('admin.staf.index')->with('success', 'Data staf berhasil diupdate!');
    }

    public function destroy($id)
    {
        $staf = Staf::with('user')->findOrFail($id);
        $staf->user->delete();
        $staf->delete();
        return redirect()->route('admin.staf.index')->with('success', 'Data staf berhasil dihapus!');
    }
}
