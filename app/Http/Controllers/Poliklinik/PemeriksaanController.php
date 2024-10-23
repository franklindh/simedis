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

        $kodeIcd = DB::table('icd')->get();


        if ($pasienDetail->isEmpty()) {
            return view('petugas.poliklinik.pemeriksaan', compact('kodeIcd'));
        }

        $idAntrian = $pasienDetail[0]->id_antrian;
        $tanggalAntrian = $pasienDetail[0]->created_at;
        Carbon::setLocale('id');
        $tanggal = Carbon::parse($tanggalAntrian)->translatedFormat('l, d F Y');

        return view('petugas.poliklinik.pemeriksaan', compact('pasienDetail', 'tanggal', 'kodeIcd', 'idAntrian'));
    }

    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'id_antrian' => 'required',
    //         'keluhan' => 'required',
    //         'keadaan_umum' => 'required',
    //         'berat_badan' => 'required',
    //         'suhu_badan' => 'required',
    //         'tekanan_darah' => 'required',
    //         'nadi' => 'required',
    //     ]);

    //     DB::table('pemeriksaan')->insert([
    //         'id_antrian' => $request->id_antrian,
    //         'keluhan' => $request->keluhan,
    //         'keadaan_umum' => $request->keadaan_umum,
    //         'berat_badan' => $request->berat_badan,
    //         'suhu' => $request->suhu_badan,
    //         'tekanan_darah' => $request->tekanan_darah,
    //         'nadi' => $request->nadi,
    //         'tanggal_pemeriksaan' => Carbon::now(),
    //         'created_at' => Carbon::now(),
    //         'updated_at' => Carbon::now(),
    //     ]);

    //     DB::table('antrian')
    //         ->where('id_antrian', $request->id_antrian)
    //         ->update([
    //             'status' => 'Menunggu Diagnosis',
    //             'updated_at' => Carbon::now(),
    //         ]);

    //     return redirect()->back()->with('success', 'Pemeriksaan pasien berhasil disimpan');
    // }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi input dari request
        // $request->validate([
        //     'id_antrian' => 'required',
        //     'keluhan' => 'required',
        //     'keadaan_umum' => 'required',
        //     'berat_badan' => 'required',
        //     'suhu_badan' => 'required',
        //     'tekanan_darah' => 'required',
        //     'diagnosis_utama' => 'required|not_in:-- Pilih --',
        //     'nadi' => 'required',
        // ]);

        // Cek apakah sudah ada data pemeriksaan untuk id_antrian tersebut
        $existingPemeriksaan = DB::table('pemeriksaan')
            ->where('id_antrian', $request->id_antrian)
            ->first();

        if ($existingPemeriksaan) {
            // Jika sudah ada data pemeriksaan, lakukan update
            DB::table('pemeriksaan')
                ->where('id_antrian', $request->id_antrian)
                ->update([
                    'keluhan' => $request->keluhan,
                    'keadaan_umum' => $request->keadaan_umum,
                    'berat_badan' => $request->berat_badan,
                    'suhu' => $request->suhu_badan,
                    'tekanan_darah' => $request->tekanan_darah,
                    'nadi' => $request->nadi,
                    'id_icd' => $request->diagnosis_utama,
                    'tindakan' => $request->rencana,
                    'updated_at' => Carbon::now(),
                ]);
        } else {
            // Jika belum ada data pemeriksaan, lakukan insert
            DB::table('pemeriksaan')->insert([
                'id_antrian' => $request->id_antrian,
                'keluhan' => $request->keluhan,
                'keadaan_umum' => $request->keadaan_umum,
                'berat_badan' => $request->berat_badan,
                'suhu' => $request->suhu_badan,
                'tekanan_darah' => $request->tekanan_darah,
                'nadi' => $request->nadi,
                'tanggal_pemeriksaan' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Update status di tabel antrian
        DB::table('antrian')
            ->where('id_antrian', $request->id_antrian)
            ->update([
                'status' => 'Menunggu Diagnosis',
                'updated_at' => Carbon::now(),
            ]);

        return redirect()->back()->with('success', 'Pemeriksaan pasien berhasil disimpan');
    }

    public function detailById($id_antrian)
    {
        // Cari data pemeriksaan berdasarkan ID antrian
        $pemeriksaan = Pemeriksaan::where('id_antrian', $id_antrian)->first();


        if (!$pemeriksaan) {
            return response()->json([
                'error' => 'Data pemeriksaan tidak ditemukan'
            ], 404); // Kembalikan status 404
        }

        $diagnosis = DB::table('icd')->where('id_icd', $pemeriksaan->id_icd)->first();

        // Kembalikan data dalam format JSON
        return response()->json([
            'keluhan' => $pemeriksaan->keluhan,
            'keadaan_umum' => $pemeriksaan->keadaan_umum,
            'berat_badan' => $pemeriksaan->berat_badan,
            'suhu_badan' => $pemeriksaan->suhu,
            'tekanan_darah' => $pemeriksaan->tekanan_darah,
            'nadi' => $pemeriksaan->nadi,
            'tindakan' => $pemeriksaan->tindakan,
            'riwayat' => $pemeriksaan->riwayat_penyakit,
        ]);
    }

    public function diagnosis($id_antrian)
    {
        return view('petugas.dokter.diagnosis');
    }

}
