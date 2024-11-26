<?php

namespace App\Http\Controllers\Administrasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Jadwal;
use App\Models\Petugas;
use App\Models\Antrian;
use App\Models\Poli;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {

        $pasienAll = DB::table('pasien')->get();
        $pasien = DB::table('pasien')->orderBy('created_at', 'desc')->paginate(5, ['*'], 'page_pasien');
        $jadwal = Jadwal::all();
        $poli = Poli::where('status', 'aktif')->get();

        $daftarAntrian = Antrian::join('jadwal', 'antrian.id_jadwal', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', 'poli.id_poli')
            ->join('pasien', 'antrian.id_pasien', 'pasien.id_pasien')
            ->select('antrian.*', 'jadwal.*', 'poli.*', 'pasien.*', 'antrian.status as status')
            ->whereDate('antrian.created_at', Carbon::today()) // Menampilkan hanya data hari ini
            ->orderBy('antrian.created_at', 'desc')
            ->paginate(5, ['*'], 'page_antrian');

        if ($request->ajax()) {
            if ($request->has('page_antrian')) {
                // For pasien pagination
                return view('petugas.administrator.tabel.antrian', compact('daftarAntrian'))->render();
            } elseif ($request->has('page_pasien')) {
                // For antrian pagination
                return view('petugas.administrator.tabel.pasien', compact('pasien'))->render();
            }
        }

        return view('petugas.administrator.pendaftaran', compact('pasien', 'pasienAll', 'jadwal', 'poli', 'daftarAntrian'));
    }

    // public function storePasien(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'nik' => 'required|numeric',
    //         'nama_pasien' => 'required|string',
    //         'tempat_lahir_pasien' => 'required',
    //         'alamat_pasien' => 'required',
    //         'tanggal_lahir_pasien' => 'required|date',
    //         'jenis_kelamin_pasien' => 'required',
    //         'no_telepon_pasien' => 'required|numeric',
    //     ], [
    //         'nik.required' => 'NIK wajib diisi.',
    //         'nama_pasien.required' => 'Nama wajib diisi.',
    //         'no_telepon_pasien.required' => 'No HP wajib diisi.',
    //         'alamat_pasien.required' => 'Alamat wajib diisi.',
    //         'tempat_lahir_pasien.required' => 'Tempat lahir wajib diisi.',
    //         'tanggal_lahir_pasien.required' => 'Tanggal lahir wajib diisi.',
    //         'jenis_kelamin_pasien.required' => 'Jenis kelamin wajib diisi.',

    //         'nik.numeric' => 'NIK harus berupa angka.',
    //         'no_telepon_pasien.numeric' => 'No HP harus berupa angka.',

    //         'tanggal_lahir_pasien.date' => 'Tanggal lahir harus berupa tanggal.',
    //     ]);

    //     // Jika validasi gagal
    //     if ($validator->fails()) {
    //         // dd($validator->errors());
    //         return redirect()->back()->withErrors($validator)->withInput()->with('modal', 'modalTambahPasien');
    //     }

    //     $namaPasien = $request->nama_pasien;
    //     $username = $this->generateUsername($namaPasien);

    //     $data = $request->all();
    //     $data['id_pasien'] = Str::uuid();
    //     $data['no_rekam_medis'] = Pasien::generateNoRM();
    //     $data['username_pasien'] = $username;
    //     $data['password'] = Hash::make('password');

    //     Pasien::create($data);

    //     return redirect()->route('pendaftaran')->with('success', "Pasien $namaPasien berhasil didaftarkan.");
    // }
    public function storePasien(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric',
            'nama_pasien' => 'required|string',
            'tempat_lahir_pasien' => 'required',
            'alamat_pasien' => 'required',
            'tanggal_lahir_pasien' => 'required|date',
            'jenis_kelamin_pasien' => 'required',
            'no_telepon_pasien' => 'required|numeric',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nama_pasien.required' => 'Nama wajib diisi.',
            'no_telepon_pasien.required' => 'No HP wajib diisi.',
            'alamat_pasien.required' => 'Alamat wajib diisi.',
            'tempat_lahir_pasien.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir_pasien.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin_pasien.required' => 'Jenis kelamin wajib diisi.',

            'nik.numeric' => 'NIK harus berupa angka.',
            'no_telepon_pasien.numeric' => 'No HP harus berupa angka.',

            'tanggal_lahir_pasien.date' => 'Tanggal lahir harus berupa tanggal.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'modalTambahPasien');
        }

        // Gunakan transaksi database
        DB::beginTransaction();
        try {
            $namaPasien = $request->nama_pasien;
            $username = $this->generateUsername($namaPasien);

            $data = $request->all();
            $data['id_pasien'] = Str::uuid();
            $data['no_rekam_medis'] = Pasien::generateNoRM();
            $data['username_pasien'] = $username;
            $data['password'] = Hash::make('password');

            Pasien::create($data);

            DB::commit(); // Jika berhasil, commit transaksi
        } catch (\Exception $e) {
            DB::rollBack(); // Jika gagal, rollback transaksi
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data pasien. Pastikan data NIK tidak duplikat.')
                ->withInput();

        }

        return redirect()->route('pendaftaran')->with('success', "Pasien $namaPasien berhasil didaftarkan.");
    }


    public function storeAntrian(Request $request)
    {
        $data = $request->all();

        $poli = Poli::find($data['id_poli']);

        switch ($poli->nama_poli) {
            case 'Anak':
                $kodePoli = 'A';
                break;
            case 'Umum':
                $kodePoli = 'U';
                break;
            case 'Lansia':
                $kodePoli = 'L';
                break;
            case 'KIA':
                $kodePoli = 'K';
                break;
            case 'Kusta':
                $kodePoli = 'KU';
                break;
            case 'Gigi':
                $kodePoli = 'G';
                break;
            default:
                $kodePoli = 'X';
                break;
        }

        $tanggalHariIni = date('Y-m-d'); // Tanggal hari ini

        // Query menghitung jumlah antrian berdasarkan poli dan tanggal
        $jumlahAntrian = Antrian::whereHas('jadwal', function ($query) use ($data) {
            $query->where('id_poli', $data['id_poli']);
        })
            ->whereDate('created_at', $tanggalHariIni)
            ->count();

        // Nomor urut baru adalah jumlah antrian yang ada + 1
        $nomorUrut = $jumlahAntrian + 1;

        // Gabungkan kode poli dengan nomor urut
        $nomorAntrian = $kodePoli . sprintf('%03d', $nomorUrut); // Menambahkan 0 di depan jika kurang dari 3 digit

        // Simpan data antrian
        Antrian::create([
            'id_jadwal' => $data['id_jadwal'],
            'id_pasien' => $data['id_pasien'],
            'nomor_antrian' => $nomorAntrian,

        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', "Antrian berhasil dibuat.");
    }


    private function generateUsername($namaPasien)
    {
        do {
            // Buat username dasar dengan menggabungkan nama dan string acak
            $baseUsername = Str::slug($namaPasien) . rand(1000, 9999);

            // Cek apakah username sudah ada di database
            $exists = Pasien::where('username_pasien', $baseUsername)->exists();
        } while ($exists); // Ulangi hingga menemukan username yang unik

        return $baseUsername;

        // $attempt = 0;
        // $maxAttempts = 100; // Batas jumlah percobaan

        // do {
        //     // Buat username dasar dengan menggabungkan nama dan string acak
        //     $baseUsername = Str::slug($namaPasien) . rand(1000, 9999);

        //     // Cek apakah username sudah ada di database
        //     $exists = Pasien::where('username_pasien', $baseUsername)->exists();

        //     $attempt++;

        //     // Jika sudah mencapai batas percobaan, berhenti dan kembalikan pesan error
        //     if ($attempt >= $maxAttempts) {
        //         throw new \Exception('Tidak bisa menemukan username yang unik. Silakan coba lagi.');
        //     }

        // } while ($exists); // Ulangi hingga menemukan username yang unik

        // return $baseUsername;
    }

    public function getPasien(Request $request)
    {
        $search = $request->search;

        $pasien = ($search == '') ? Pasien::limit(10)->get() : Pasien::where('nama_pasien', 'like', "%$search%")->limit(10)->get();

        $response = [];
        foreach ($pasien as $p) {
            $response[] = [
                "nik" => $p->nik,
                "nama_pasien" => $p->nama_pasien
            ];
        }

        return response()->json($response);
    }

    public function getDokter(Request $request)
    {
        // $doctors = Petugas::where('role', $request->poli)->get();
        // $dokter = Petugas::where('role', )
        $dokter = DB::table('petugas')
            ->join('jadwal', 'petugas.id_petugas', 'jadwal.id_petugas')
            ->join('poli', 'jadwal.id_poli', 'poli.id_poli')
            ->select('petugas.id_petugas', 'petugas.nama_petugas', 'poli.nama_poli')
            ->where('poli.id_poli', $request->poli)
            ->get();

        if ($dokter->isEmpty()) {
            return response()->json(['error', 'icikiwir'], 404);
        }
        return response()->json(['doctors' => $dokter]);
    }

    public function getJadwal(Request $request)
    {
        // $jadwal = Jadwal::where('id_poli', $request->poli_id)->get();
        $jadwal = DB::table('jadwal')
            ->join('petugas', 'jadwal.id_petugas', '=', 'petugas.id_petugas') // Sesuaikan nama tabel dan kolom
            ->select(
                'jadwal.id_jadwal',
                'jadwal.tanggal_praktik',
                'jadwal.waktu_mulai',
                'jadwal.waktu_selesai',
                'jadwal.keterangan',
                'petugas.nama_petugas' // Ambil nama petugas
            )
            ->where('jadwal.id_poli', $request->poli_id)
            ->get();

        if ($jadwal->isEmpty()) {
            return response()->json(['status' => 'kosong']);
        }

        return response()->json(['status' => 'success', 'data' => $jadwal]);
    }

    public function searchPasien(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query'); // Ambil query dari input
            if ($query != '') {
                // Lakukan pencarian berdasarkan nama pasien atau NIK
                $pasien = Pasien::where('nama_pasien', 'like', '%' . $query . '%')
                    ->orWhere('nik', 'like', '%' . $query . '%')
                    ->paginate(10);
            } else {
                // Jika tidak ada query, tampilkan semua pasien
                $pasien = Pasien::paginate(10);
            }

            // Kembalikan view tabel pasien yang diperbarui
            return view('petugas.administrator.tabel.pasien', compact('pasien'))->render();
        }
    }

    public function searchAntrian(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $poli = $request->get('poli');
            $status = $request->get('status');

            $daftarAntrian = Antrian::join('jadwal', 'antrian.id_jadwal', 'jadwal.id_jadwal')
                ->join('poli', 'jadwal.id_poli', 'poli.id_poli')
                ->join('pasien', 'antrian.id_pasien', 'pasien.id_pasien')
                ->select('antrian.*', 'jadwal.*', 'poli.*', 'pasien.*')
                ->whereDate('antrian.created_at', Carbon::today()) // Menampilkan hanya data hari ini
                ->when($query, function ($q) use ($query) {
                    $q->where(function ($q) use ($query) {
                        $q->where('antrian.nomor_antrian', 'like', '%' . $query . '%')
                            ->orWhere('pasien.nama_pasien', 'like', '%' . $query . '%')
                            ->orWhere('poli.nama_poli', 'like', '%' . $query . '%')
                            ->orWhere('antrian.status', 'like', '%' . $query . '%');
                    });
                })
                ->when($poli, function ($q) use ($poli) {
                    return $q->where('jadwal.id_poli', $poli); // Filter berdasarkan poli
                })
                ->when($status, function ($q) use ($status) {
                    return $q->where('antrian.status', $status); // Filter berdasarkan status
                })
                ->orderBy('antrian.created_at', 'desc')
                ->paginate(5, ['*'], 'page_antrian');


            return view('petugas.administrator.tabel.antrian', compact('daftarAntrian'))->render();
        }
    }



}


