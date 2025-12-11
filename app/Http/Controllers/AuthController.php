<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function register() {
        
    }
}
