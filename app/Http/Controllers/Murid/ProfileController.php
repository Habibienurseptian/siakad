<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Murid;
use App\Models\User;

class ProfileController extends Controller
{
    // Halaman profil murid
    public function index()
    {
        $murid = Murid::with('user')->where('user_id', Auth::id())->firstOrFail();
        return view('murid.profile.index', compact('murid'));
    }

    // Halaman edit profil (tanpa upload foto)
    public function edit()
    {
        $murid = Murid::with('user')->where('user_id', Auth::id())->firstOrFail();
        return view('murid.profile.edit', compact('murid'));
    }

    // Update data profil tanpa ubah foto
    public function update(Request $request)
    {
        $murid = Murid::where('user_id', Auth::id())->firstOrFail();
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:14',
            'nama_orangtua' => 'nullable|string|max:255',
            'telepon_orangtua' => 'nullable|string|max:14',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'warga_negara' => 'nullable|string|max:100',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:5',
            'tempat_lahir_orangtua' => 'nullable|string|max:100',
            'tanggal_lahir_orangtua' => 'nullable|date',
        ]);

        // Update data user
        $user->update(['email' => $request->email]);

        // Update data murid (tanpa ubah foto)
        $murid->update([
            'jenis_kelamin' => $request->jenis_kelamin,
            'phone' => $request->phone,
            'nama_orangtua' => $request->nama_orangtua,
            'telepon_orangtua' => $request->telepon_orangtua,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warga_negara' => $request->warga_negara,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'tempat_lahir_orangtua' => $request->tempat_lahir_orangtua,
            'tanggal_lahir_orangtua' => $request->tanggal_lahir_orangtua,
        ]);

        return redirect()->route('murid.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    // Tampilkan form reset password
    public function showResetForm()
    {
        return view('murid.profile.reset-password');
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('murid.profile')
            ->with('success', 'Password berhasil diubah!');
    }
}
