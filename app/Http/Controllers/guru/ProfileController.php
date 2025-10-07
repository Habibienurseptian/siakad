<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $guru = \App\Models\Guru::where('user_id', auth()->id())->first();
        return view('guru.profile.index', compact('guru'));
    }

    public function edit()
    {
        $guru = \App\Models\Guru::where('user_id', auth()->id())->first();
        return view('guru.profile.edit', compact('guru'));
    }

    public function destroy()
    {
        $user = Auth::user();
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }
        $user->delete();
        return redirect('/')->with('success', 'Profil berhasil dihapus!');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $guru = \App\Models\Guru::where('user_id', $user->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'nip' => 'nullable|string',
            'phone' => 'nullable|interger|max:14',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update user table
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Update guru table
        $guru->nip = $request->nip;
        $guru->phone = $request->phone;
        $guru->tempat_lahir = $request->tempat_lahir;
        $guru->tanggal_lahir = $request->tanggal_lahir;
        $guru->warga_negara = $request->warga_negara;
        $guru->alamat = $request->alamat;
        $guru->kode_pos = $request->kode_pos;
        $guru->tempat_lahir_orangtua = $request->tempat_lahir_orangtua;
        $guru->tanggal_lahir_orangtua = $request->tanggal_lahir_orangtua;
        $guru->status_marital = $request->status_marital;
        $guru->nama_orangtua = $request->nama_orangtua;
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $guru->profile_image = $path;
        }
        $guru->save();

        return redirect()->route('guru.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
