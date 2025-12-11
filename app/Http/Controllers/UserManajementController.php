<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserManajementController extends Controller
{
    public function index()
    {
        return view('admin.pengguna.user_management', [
            'users'=> \App\Models\User::paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:t_users,email',
            'username' => 'required|string|unique:t_users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        \App\Models\User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);

        return response()->json(['message' => 'Pengguna baru berhasil ditambahkan.'], 201);
    }

    public function updateRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:t_users,id',
            'role' => 'required|string',
        ]);

        $user = \App\Models\User::find($request->input('user_id'));
        $user->role = $request->input('role');
        $user->save();

        return response()->json(['message' => 'Role pengguna berhasil diperbarui.'], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:t_users,id',
            'password'=> 'required|string|min:6',
        ]);

        $user = \App\Models\User::find($request->input('user_id'));
        $newPassword = $request->input('password');
        $user->password = bcrypt($newPassword);
        $user->save();

        return response()->json(['message' => 'Password pengguna berhasil direset.', 'new_password' => $newPassword], 200);
    }
}
