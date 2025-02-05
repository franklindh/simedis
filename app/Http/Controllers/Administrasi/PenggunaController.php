<?php

namespace App\Http\Controllers\Administrasi;

use App\Models\Petugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        // $daftarPengguna = Petugas::orderBy('created_at', 'desc')->paginate(5, ['*'], 'page_pengguna');
        $poli = DB::table('poli')->get();
        $daftarPengguna = DB::table('petugas')
            ->leftJoin('poli', 'petugas.id_poli', '=', 'poli.id_poli')
            ->select(
                'petugas.id_petugas',
                'petugas.username_petugas',
                'petugas.nama_petugas',
                'petugas.role',
                'petugas.status',
                'poli.nama_poli',
                'poli.id_poli'
            )
            ->orderBy('petugas.created_at', 'desc')
            ->paginate(5, ['*'], 'page_pengguna');

        if ($request->ajax()) {
            return view('petugas.administrator.tabel.pengguna', compact('daftarPengguna'))->render();
        }
        // dd($daftarPengguna);
        return view('petugas.administrator.pengguna', compact('daftarPengguna', 'poli'));
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

        return redirect()->route('data.pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function resetPassword($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->update([
            'password' => bcrypt('123456'),
        ]);

        return redirect()->route('data.pengguna')->with('success', "Password {$petugas->nama_petugas} berhasil direset.");
    }

    public function nonaktifPetugas($id)
    {
        $petugas = Petugas::findOrFail($id);
        $idPetugasLogin = Auth::guard('petugas')->user()->id_petugas;

        if ($idPetugasLogin == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan diri sendiri.');
        }

        $petugas->update([
            'status' => 'nonaktif',
        ]);

        return redirect()->route('data.pengguna')->with('success', "Pengguna {$petugas->nama_petugas} berhasil dinonaktifkan.");
    }
    public function aktifPetugas($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->update([
            'status' => 'aktif',
        ]);

        return redirect()->route('data.pengguna')->with('success', "Pengguna {$petugas->nama_petugas} berhasil dinonaktifkan.");
    }

    public function updatePengguna(Request $request, $id)
    {
        // dd($request->all());
        // Ambil data pengguna berdasarkan ID
        $pengguna = Petugas::findOrFail($id);
        // Validasi data input
        $validatedData = $request->validate([
            'username_petugas' => 'required|string|max:255|exists:Petugas,username_petugas',
            'nama_petugas' => 'required|string|max:255',
            'role' => 'required|in:Administrasi,Poliklinik,Dokter',
            'id_poli' => 'nullable|exists:Poli,id_poli', // Hanya valid jika poli dipilih
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'peran.required' => 'Peran wajib dipilih.',
            'id_poli.exists' => 'Poli yang dipilih tidak valid.',
        ]);

        // Update data pengguna
        $pengguna->update([
            'username_petugas' => $validatedData['username_petugas'],
            'nama_petugas' => $validatedData['nama_petugas'],
            'role' => $validatedData['role'],
            'id_poli' => $validatedData['id_poli'] ?? null, // Null jika poli tidak dipilih
            'status' => $request->status,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('data.pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }


}
