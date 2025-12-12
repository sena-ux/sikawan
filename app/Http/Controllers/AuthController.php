<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->role === 'pegawai') {
                return response()->json(['redirect' => route('dashboard')], 200);
            } else{
                return response()->json(['redirect' => route('dashboard')], 200);
            }
        }

        return response()->json(['success' => false, 'message' => 'The provided credentials do not match our records.'], 422);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'namaLengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:30',
            'email' => 'required|string|email|max:255|unique:t_users',
            'nip' => 'nullable|string|max:30',
            'jenisJabatan' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'noHp' => 'nullable|string|max:15',
            'fotoProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if NIK already exists
        $nikExists = \App\Models\Pegawai::where('nik', $validated['nik'])->exists();
        if ($nikExists) {
            return response()->json(['success' => false, 'message' => 'NIK sudah terdaftar.'], 422);
        }

        // Create user
        $user = \App\Models\User::create([
            'username' => $validated['nik'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['nik']),
            'role' => $validated['jenisJabatan'] ?? 'pegawai',
        ]);

        // Handle file upload
        $profilePath = null;
        if ($request->hasFile('fotoProfile')) {
            $profilePath = $request->file('fotoProfile')->move('uploads/profiles', $user->id . '_' . time() . '.' . $request->file('fotoProfile')->getClientOriginalExtension());
        }

        // Create pegawai record
        \App\Models\Pegawai::create([
            'user_id' => $user->id,
            'nik' => $validated['nik'],
            'nip' => $validated['nip'],
            'nama_lengkap' => $validated['namaLengkap'],
            'jabatan' => $validated['jabatan'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['noHp'],
            'profile' => $profilePath,
        ]);

        // auth()->login($user);

        Alert::success('Registrasi berhasil! Silakan login dengan NIK Anda sebagai username dan password.');
        return redirect()->route('login');

    }
}
