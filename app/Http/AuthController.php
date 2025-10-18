<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    // ✅ Register
    public function register(Request $request)
    {
        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'sekolah_universitas' => 'nullable|string|max:150',
            'nama_pembimbing' => 'nullable|string|max:150',
            'periode_magang' => 'nullable|string|max:100',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'email' => 'required|email|unique:users',
            'no_telp' => 'nullable|string|max:20',
            'username' => 'required|string|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Upload CV
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public');
        }

        $user = User::create([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'sekolah_universitas' => $request->sekolah_universitas,
            'nama_pembimbing' => $request->nama_pembimbing,
            'periode_magang' => $request->periode_magang,
            'cv' => $cvPath,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->only('username', 'password');


        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }
}
