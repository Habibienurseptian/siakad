<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Pendaftaran berhasil!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $loginId = $request->login_id;
        $password = $request->password;

        $user = null;

        // Cek apakah input berupa email → login admin
        if (filter_var($loginId, FILTER_VALIDATE_EMAIL)) {
            $user = \App\Models\User::where('email', $loginId)->first();
        } else {
            // Cek berdasarkan NIP (guru/staf)
            $userGuru = \App\Models\Guru::where('nip', $loginId)->first();
            $userStaf = \App\Models\Staf::where('nip', $loginId)->first();
            $userMurid = \App\Models\Murid::where('nomor_induk', $loginId)->first();

            if ($userGuru) {
                $user = $userGuru->user;
            } elseif ($userStaf) {
                $user = $userStaf->user;
            } elseif ($userMurid) {
                $user = $userMurid->user;
            }
        }

        if (!$user) {
            return back()->withErrors(['login_id' => 'Akun tidak ditemukan.'])->withInput();
        }

        // Autentikasi menggunakan email (karena email tetap di tabel users)
        if (Auth::attempt(['email' => $user->email, 'password' => $password])) {
            $request->session()->regenerate();

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Admin!');
                case 'staf':
                    return redirect()->route('staf.dashboard')->with('success', 'Login berhasil sebagai Staf!');
                case 'guru':
                    return redirect()->route('guru.dashboard')->with('success', 'Login berhasil sebagai Guru!');
                case 'murid':
                    return redirect()->route('murid.dashboard')->with('success', 'Login berhasil sebagai Murid!');
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors(['login_id' => 'Role tidak valid.']);
            }
        }

        return back()->withErrors(['login_id' => 'Kata sandi salah.'])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
