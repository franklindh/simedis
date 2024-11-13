<?php

namespace App\Http\Controllers\Poliklinik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pemeriksaan;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $pasienDetail = DB::table('antrian')
            ->join('pasien', 'antrian.id_pasien', 'pasien.id_pasien')
            ->join('jadwal', 'antrian.id_jadwal', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', 'poli.id_poli')
            ->select('antrian.*', 'pasien.nama_pasien', 'pasien.no_rekam_medis', 'jadwal.*', 'poli.*')
            ->whereDate('antrian.created_at', Carbon::today()) // Hanya data hari ini
            ->orderBy('nomor_antrian', 'asc')
            ->paginate(5);

        if ($pasienDetail->isEmpty()) {
            return view('petugas.poliklinik-dokter.periksa');
        }

        $idAntrian = $pasienDetail[0]->id_antrian;
        $tanggalAntrian = $pasienDetail[0]->created_at;
        Carbon::setLocale('id');
        $tanggal = Carbon::parse($tanggalAntrian)->translatedFormat('l, d F Y');

        return view('petugas.poliklinik-dokter.periksa', compact('pasienDetail', 'tanggal', 'idAntrian'));
    }

    public function store(Request $request)
    {

        // Cek apakah sudah ada data pemeriksaan untuk id_antrian tersebut

        $validatedData = $request->validate([
            'keluhan' => 'required',
            'riwayat' => 'required',
            'keadaan_umum' => 'required',
            'berat_badan' => 'required|numeric',
            'suhu_badan' => 'required|numeric',
            'tekanan_darah' => 'required',
            'nadi' => 'required|numeric',
            // 'tindakan' => 'required',
        ], [
            'keluhan.required' => 'Keluhan wajib diisi.',
            'riwayat.required' => 'Riwayat penyakit wajib diisi.',
            'keadaan_umum.required' => 'Keadaan umum wajib diisi.',
            'berat_badan.required' => 'Berat badan wajib diisi.',
            'berat_badan.numeric' => 'Berat badan harus berupa angka.',
            'suhu_badan.required' => 'Suhu badan wajib diisi.',
            'suhu_badan.numeric' => 'Suhu badan harus berupa angka.',
            'tekanan_darah.required' => 'Tekanan darah wajib diisi.',
            'nadi.required' => 'Nadi wajib diisi.',
            'nadi.numeric' => 'Nadi harus berupa angka.',
            'tindakan.required' => 'Tindakan wajib diisi.',
        ]);
        // dd($validatedData);
        $existingPemeriksaan = DB::table('pemeriksaan')
            ->where('id_antrian', $request->idAntrian)
            ->first();

        // dd($request->all());

        if ($existingPemeriksaan) {
            // Jika sudah ada data pemeriksaan, lakukan update
            DB::table('pemeriksaan')
                ->where('id_antrian', $request->idAntrian)
                ->update([
                    'id_icd' => $request->icd,
                    'keluhan' => $validatedData['keluhan'],
                    'riwayat_penyakit' => $validatedData['riwayat'],
                    'keadaan_umum' => $validatedData['keadaan_umum'],
                    'berat_badan' => $validatedData['berat_badan'],
                    'suhu' => $validatedData['suhu_badan'],
                    'tekanan_darah' => $validatedData['tekanan_darah'],
                    'nadi' => $validatedData['nadi'],
                    'tindakan' => $request->tindakan,
                    'updated_at' => Carbon::now(),
                ]);
            // Update status di tabel antrian
            DB::table('antrian')
                ->where('id_antrian', $request->idAntrian)
                ->update([
                    'status' => 'Selesai',
                    'updated_at' => Carbon::now(),
                ]);
        } else {
            // Jika belum ada data pemeriksaan, lakukan insert
            DB::table('pemeriksaan')->insert([
                'id_antrian' => $request->idAntrian,
                'id_icd' => $request->icd,
                'keluhan' => $validatedData['keluhan'],
                'riwayat_penyakit' => $validatedData['riwayat'],
                'keadaan_umum' => $validatedData['keadaan_umum'],
                'berat_badan' => $validatedData['berat_badan'],
                'suhu' => $validatedData['suhu_badan'],
                'tekanan_darah' => $validatedData['tekanan_darah'],
                'nadi' => $validatedData['nadi'],
                'tanggal_pemeriksaan' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            // Update status di tabel antrian
            DB::table('antrian')
                ->where('id_antrian', $request->idAntrian)
                ->update([
                    'status' => 'Menunggu Diagnosis',
                    'updated_at' => Carbon::now(),
                ]);
        }

        // return redirect()->back()->with('success', 'Pemeriksaan pasien berhasil disimpan');
        return redirect()->route('pemeriksaan')->with('success', 'Pemeriksaan pasien berhasil disimpan');
    }

    // public function detailById($id_antrian)
    // {
    //     // Cari data pemeriksaan berdasarkan ID antrian
    //     $pemeriksaan = Pemeriksaan::where('id_antrian', $id_antrian)->first();


    //     if (!$pemeriksaan) {
    //         return response()->json([
    //             'error' => 'Data pemeriksaan tidak ditemukan'
    //         ], 404); // Kembalikan status 404
    //     }

    //     $diagnosis = DB::table('icd')->where('id_icd', $pemeriksaan->id_icd)->first();

    //     // Kembalikan data dalam format JSON
    //     return response()->json([
    //         'keluhan' => $pemeriksaan->keluhan,
    //         'keadaan_umum' => $pemeriksaan->keadaan_umum,
    //         'berat_badan' => $pemeriksaan->berat_badan,
    //         'suhu_badan' => $pemeriksaan->suhu,
    //         'tekanan_darah' => $pemeriksaan->tekanan_darah,
    //         'nadi' => $pemeriksaan->nadi,
    //         'tindakan' => $pemeriksaan->tindakan,
    //         'riwayat' => $pemeriksaan->riwayat_penyakit,
    //     ]);
    // }

    public function show($id_antrian)
    {
        // dd($id_antrian);
        $pemeriksaan = Pemeriksaan::where('id_antrian', $id_antrian)->first();
        $idAntrian = $id_antrian;
        // dd($idAntrian);
        // dd($pemeriksaan == null);
        if (!is_null($pemeriksaan)) {
            // return redirect()->route('pemeriksaan')->with('error', 'Data pemeriksaan tidak ditemukan.');
            // dd($pemeriksaan);
            return view('petugas.poliklinik-dokter.periksa-detail', compact('pemeriksaan', 'idAntrian'));
        }

        $kodeIcd = DB::table('icd')->get();
        return view('petugas.poliklinik-dokter.periksa-detail', compact('pemeriksaan', 'idAntrian'));
    }

    public function diagnosis()
    {
        return view('petugas.dokter.diagnosis');
    }

    // public function getIcdList(Request $request)
    // {
    //     $search = $request->get('search');

    //     $icdList = DB::table('icd')
    //         ->select('id_icd', 'kode_icd', 'nama_penyakit')
    //         ->when($search, function ($query) use ($search) {
    //             return $query->where('kode_icd', 'like', "%{$search}%")
    //                 ->orWhere('nama_penyakit', 'like', "%{$search}%");
    //         })
    //         ->limit(10)
    //         ->get();

    //     $formattedIcdList = $icdList->map(function ($icd) {
    //         return [
    //             'id' => $icd->id_icd,
    //             'text' => "{$icd->kode_icd} - {$icd->nama_penyakit}"
    //         ];
    //     });

    //     return response()->json($formattedIcdList);
    // }
    public function getIcdList(Request $request)
    {
        $search = $request->get('search');
        $icdList = DB::table('icd')
            ->select('id_icd', 'kode_icd', 'nama_penyakit')
            ->when($search, function ($query) use ($search) {
                return $query->where('kode_icd', 'like', "%{$search}%")
                    ->orWhere('nama_penyakit', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get();

        $formattedIcdList = $icdList->map(function ($icd) {
            return [
                'id' => $icd->id_icd,
                'text' => "{$icd->kode_icd} - {$icd->nama_penyakit}"
            ];
        });

        return response()->json($formattedIcdList);
    }

}
