<?php

namespace App\Http\Controllers\Administrasi;

use App\Models\Petugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $daftarPengguna = Petugas::paginate(5, ['*'], 'page_pengguna');

        if ($request->ajax()) {
            return view('petugas.administrator.tabel.pengguna', compact('daftarPengguna'))->render();
        }

        return view('petugas.administrator.pengguna', compact('daftarPengguna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:petugas,username_petugas',
            'role' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih username yang lain.',
            'role.required' => 'Role wajib diisi.',
        ]);

        Petugas::create([
            'nama_petugas' => $request->nama,
            'username_petugas' => $request->username,
            'role' => $request->role,
            'password' => bcrypt('123456'),
        ]);

        return redirect()->route('pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function resetPassword($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->update([
            'password' => bcrypt('123456'),
        ]);

        return redirect()->route('pengguna')->with('success', 'Password ' . $petugas->nama_petugas . ' berhasil direset.');
    }

    public function nonaktifPetugas($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->update([
            'status' => 'nonaktif',
        ]);

        return redirect()->route('pengguna')->with('success', 'Pengguna ' . $petugas->nama_petugas . ' berhasil dinonaktifkan.');
    }
}
