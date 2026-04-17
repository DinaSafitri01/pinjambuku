<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function landing()
    {
        return view('landing');
    }
    
    public function welcome()
    {
        return view('auth.welcome');
    }

    public function loginSiswa()
    {
        return view('auth.login-siswa');
    }

    public function loginAdmin()
    {
        return view('auth.login-admin');
    }

    public function registerSiswa()
    {
        return view('auth.register-siswa');
    }

    public function registerAdmin()
    {
        return view('auth.register-admin');
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:users,nis',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'nis.unique' => 'NIS sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        User::create([
            'nis' => $request->nis,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'role' => 'siswa',
        ]);

        return redirect()->route('login.siswa')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('login.admin')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function authSiswa(Request $request)
    {
        $credentials = $request->validate([
            'nis' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['nis' => $credentials['nis'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('siswa.dashboard'));
        }

        return back()->withErrors(['nis' => 'NIS atau password salah.'])->withInput();
    }

    public function authAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Kredensial tidak cocok.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome');
    }
}
