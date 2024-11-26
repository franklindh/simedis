<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        if (Auth::guard('petugas')->attempt(['username_petugas' => $request->username, 'password' => $request->password])) {
            $user = Auth::guard('petugas')->user();
            // dd($user->role);
            switch ($user->role) {
                case 'Administrasi':
                    return redirect()->route('rekam');
                case 'Dokter':
                    return redirect()->route('rekam');
                case 'Poliklinik':
                    return redirect()->route('rekam');
            }
        }

        return redirect()->route('login')->with('error', 'Username atau Password salah');
    }

    public function logout()
    {
        // dd('logout');
        Auth::guard('petugas')->logout();

        return redirect()->route('login');
    }
}