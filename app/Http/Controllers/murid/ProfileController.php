<?php
namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Murid;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $murid = Murid::where('user_id', auth()->id())->first();
        return view('murid.profile.index', compact('murid'));
    }

    public function destroy()
    {
        $murid = Murid::where('user_id', Auth::id())->first();
        if ($murid->profile_image) {
            Storage::disk('public')->delete($murid->profile_image);
        }
        $murid->delete();
        return redirect('/')->with('success', 'Profil berhasil dihapus!');
    }

    public function edit()
    {
        $murid = \App\Models\Murid::where('user_id', auth()->id())->first();
        return view('murid.profile.edit', compact('murid'));
    }

    public function update(Request $request)
    {
        $murid = Murid::where('user_id', auth()->id())->first();
        $request->validate([
            'phone' => 'nullable|integer|max:14',
            'nama_orangtua' => 'nullable|string|max:255',
            'telepon_orangtua' => 'nullable|integer|max:14',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $murid->fill([
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
        if ($request->hasFile('profile_image')) {
            if (!\Storage::disk('public')->exists('profile_image')) {
                \Storage::disk('public')->makeDirectory('profile_image');
            }
            if ($murid->profile_image) {
                \Storage::disk('public')->delete($murid->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_image', 'public');
            $murid->profile_image = $path;
        }
        $murid->save();
        return redirect()->route('murid.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function showResetForm()
    {
        return view('murid.profile.reset-password');
    }

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

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('murid.profile')->with('success', 'Password berhasil direset!');
    }

}
