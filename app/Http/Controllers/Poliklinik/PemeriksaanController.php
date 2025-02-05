<?php

namespace App\Http\Controllers\Poliklinik;

use App\Models\Antrian;
use App\Models\ICD;
use App\Models\PemeriksaanLab;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pemeriksaan;
use PDF;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $user = Auth::guard('petugas')->user();
        $role = $user->role;
        $idPoliPetugas = $user->id_poli;

        switch ($role) {
            case 'Dokter':
                $pasienDetail = DB::table('antrian')
                    ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
                    ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
                    ->join('petugas', 'jadwal.id_petugas', '=', 'petugas.id_petugas')
                    ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
                    ->select(
                        'antrian.*',
                        'pasien.nama_pasien',
                        'pasien.no_rekam_medis',
                        'jadwal.*',
                        'poli.*',
                        'antrian.status'
                    )
                    ->whereDate('antrian.created_at', Carbon::today())
                    ->where('jadwal.id_petugas', $user->id_petugas)
                    ->orderBy('status', 'desc')
                    ->orderBy('nomor_antrian', 'asc')
                    ->paginate(5);
                break;
            default:
                $pasienDetail = DB::table('antrian')
                    ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
                    ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
                    ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
                    ->select(
                        'antrian.*',
                        'pasien.nama_pasien',
                        'pasien.no_rekam_medis',
                        'jadwal.*',
                        'poli.*',
                        'antrian.status'
                    )
                    ->whereDate('antrian.created_at', Carbon::today())
                    ->when($role === 'Poliklinik', function ($query) use ($idPoliPetugas) {
                        return $query->where('jadwal.id_poli', $idPoliPetugas);
                    })
                    ->orderBy('nomor_antrian', 'asc')
                    ->paginate(5);
                break;
        }
        // dd($pasienDetail);
        $tanggal = Carbon::now()->translatedFormat('l, d F Y');
        $idAntrian = $pasienDetail->isEmpty() ? null : $pasienDetail[0]->id_antrian;

        return view('petugas.poliklinik-dokter.periksa', [
            'pasienDetail' => $pasienDetail,
            'tanggal' => $tanggal,
            'idAntrian' => $idAntrian,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'keluhan' => 'required',
            'riwayat' => 'nullable',
            'keadaan_umum' => 'required',
            'berat_badan' => 'required|numeric',
            'suhu_badan' => 'required|numeric',
            'nadi' => 'required|numeric',
            'tekanan_darah' => 'required',
            'pemeriksaan_lab' => 'nullable|array',
            'pemeriksaan_lab.*' => 'required|array',
        ]);

        $existingPemeriksaan = Pemeriksaan::where('id_antrian', $request->idAntrian)->first();

        $kodeLab = $request->jenis_pemeriksaan_lab ? mt_rand(10000, 99999) : null;

        $data = [
            'id_icd' => $request->id_icd,
            'id_antrian' => $request->idAntrian,
            'keluhan' => $validatedData['keluhan'],
            'riwayat_penyakit' => $validatedData['riwayat'],
            'keadaan_umum' => $validatedData['keadaan_umum'],
            'berat_badan' => $validatedData['berat_badan'],
            'suhu' => $validatedData['suhu_badan'],
            'tekanan_darah' => $validatedData['tekanan_darah'],
            'nadi' => $validatedData['nadi'],
            'tindakan' => $request->tindakan ?? null,
            'tanggal_pemeriksaan' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $status = ($request->id_icd && $request->tindakan) ? 'Selesai' : 'Menunggu Diagnosis';

        $existingPemeriksaan
            ? $existingPemeriksaan->update($data)
            : Pemeriksaan::create($data);

        Antrian::where('id_antrian', $request->idAntrian)->update([
            'status' => $status,
            'updated_at' => Carbon::now(),
        ]);

        if ($request->has('pemeriksaan_lab')) {
            foreach ($request->input('pemeriksaan_lab') as $jenis => $pemeriksaans) {
                foreach ($pemeriksaans as $pemeriksaan) {
                    $existingLab = PemeriksaanLab::where([
                        ['id_pemeriksaan', '=', $existingPemeriksaan->id_pemeriksaan],
                        ['nama_pemeriksaan', '=', $pemeriksaan],
                        ['jenis_pemeriksaan', '=', $jenis],
                    ])->first();

                    if (!$existingLab) {
                        PemeriksaanLab::create([
                            'kode_lab' => $kodeLab,
                            'jenis_pemeriksaan' => $jenis,
                            'nama_pemeriksaan' => $pemeriksaan,
                            'id_pemeriksaan' => $existingPemeriksaan->id_pemeriksaan,
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Pemeriksaan berhasil diperbarui.');
    }


    public function show($id_antrian)
    {

        $user = Auth::guard('petugas')->user();
        $role = $user->role;

        // Ambil data pemeriksaan
        $pemeriksaan = Pemeriksaan::where('id_antrian', $id_antrian)->first();

        // dd($pemeriksaan->id_icd);
        // dd($pemeriksaan);
        $groupedPemeriksaan = DB::table('jenis_pemeriksaan_lab')
            ->select('*')
            ->orderBy('kriteria')
            ->get()
            ->groupBy('kriteria');
        // ->groupBy('kriteria');
        // dd($groupedPemeriksaan);
        if ($pemeriksaan === null) {
            $idAntrian = $id_antrian;
            $data = DB::table('antrian')
                ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
                ->select(
                    'antrian.*',
                    'pasien.nama_pasien',
                    'pasien.no_rekam_medis',
                )
                ->where('antrian.id_antrian', $idAntrian)
                ->first();

            $kodeIcd = ($role === 'Dokter') ? ICD::where('status_icd', 'aktif')->get() : null;

            return view('petugas.poliklinik-dokter.periksa-detail', compact('pemeriksaan', 'idAntrian', 'kodeIcd', 'role', 'data', 'groupedPemeriksaan'));
        }

        $pemeriksaanLab = PemeriksaanLab::where('id_pemeriksaan', $pemeriksaan->id_pemeriksaan)->get();
        $idAntrian = $id_antrian;
        $data = DB::table('antrian')
            ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
            ->select(
                'antrian.*',
                'pasien.nama_pasien',
                'pasien.no_rekam_medis',
            )
            ->where('antrian.id_antrian', $idAntrian)
            ->first();
        // dd($pemeriksaanLab);

        $kodeIcd = ($role === 'Dokter') ? ICD::where('status_icd', 'aktif')->get() : null;
        // dd($pemeriksaanLab);
        // $jenisPemeriksaanLab = 

        return view('petugas.poliklinik-dokter.periksa-detail', compact('pemeriksaan', 'idAntrian', 'kodeIcd', 'role', 'data', 'pemeriksaanLab', 'groupedPemeriksaan'));
    }


    public function diagnosis()
    {
        return view('petugas.dokter.diagnosis');
    }

    public function getIcdList(Request $request)
    {
        // $search = $request->get('search');
        // $icdList = DB::table('icd')
        //     ->select('id_icd', 'kode_icd', 'nama_penyakit')
        //     ->when($search, function ($query) use ($search) {
        //         return $query->where('kode_icd', 'like', "%{$search}%")
        //             ->orWhere('nama_penyakit', 'like', "%{$search}%");
        //     })
        //     ->limit(10)
        //     ->get();

        // $formattedIcdList = $icdList->map(function ($icd) {
        //     return [
        //         'id' => $icd->id_icd,
        //         'text' => "{$icd->kode_icd} - {$icd->nama_penyakit}"
        //     ];
        // });

        // return response()->json($formattedIcdList);
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $limit = 10;

        // $icdList = ICD::where('nama_penyakit', 'like', '%' . $search . '%')
        //     ->orWhere('kode_icd', 'like', "%$search%")
        //     ->offset(($page - 1) * $limit)
        //     ->limit($limit)
        //     ->get();

        // $hasMore = ICD::where('nama_penyakit', 'like', '%' . $search . '%')
        //     ->orWhere('kode_icd', 'like', '%' . $search . '%')
        //     ->count() > ($page * $limit);

        $icdList = ICD::where('status', 'aktif') // Hanya tampilkan ICD aktif
            ->where(function ($query) use ($search) {
                $query->where('nama_penyakit', 'like', '%' . $search . '%')
                    ->orWhere('kode_icd', 'like', '%' . $search . '%');
            })
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        $hasMore = ICD::where('status', 'aktif') // Hanya hitung ICD aktif
            ->where(function ($query) use ($search) {
                $query->where('nama_penyakit', 'like', '%' . $search . '%')
                    ->orWhere('kode_icd', 'like', '%' . $search . '%');
            })
            ->count() > ($page * $limit);


        return response()->json([
            'results' => $icdList->map(function ($icd) {
                return [
                    'id' => $icd->id_icd,
                    'text' => "{$icd->kode_icd} - {$icd->nama_penyakit}"
                ];
            }),
            'pagination' => [
                'more' => $hasMore
            ]
        ]);
    }

    public function lab(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // $pemeriksaan = PemeriksaanLab::paginate(5, ['*'], 'page_pemeriksaan');
        // $pemeriksaan = DB::table('pemeriksaan_lab')
        //     ->join('pemeriksaan', 'pemeriksaan_lab.id_pemeriksaan', '=', 'pemeriksaan.id_pemeriksaan') // Join ke tabel antrian
        //     ->join('antrian', 'pemeriksaan.id_antrian', '=', 'antrian.id_antrian') // Join ke tabel antrian
        //     ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal') // Join ke tabel jadwal
        //     ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli') // Join ke tabel poli
        //     ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien') // Join ke tabel pasien
        //     ->select('pemeriksaan_lab.*', 'pasien.nama_pasien', 'poli.nama_poli')
        //     ->groupBy('pasien.nama_pasien') // Pastikan hanya satu baris per pasien // Pilih kolom yang diinginkan
        //     ->paginate(5, ['*'], 'page_pemeriksaan');

        $pemeriksaan = DB::table('pemeriksaan_lab')
            ->join('pemeriksaan', 'pemeriksaan_lab.id_pemeriksaan', '=', 'pemeriksaan.id_pemeriksaan')
            ->join('antrian', 'pemeriksaan.id_antrian', '=', 'antrian.id_antrian')
            ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
            ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
            ->select(
                'pemeriksaan_lab.id_pemeriksaan_lab',
                'pemeriksaan_lab.hasil',
                'pemeriksaan_lab.kode_lab',
                'pemeriksaan.id_pemeriksaan',
                'pasien.nama_pasien',
                'poli.nama_poli',
                'pemeriksaan_lab.created_at'
            )
            ->whereIn('pemeriksaan_lab.id_pemeriksaan_lab', function ($query) {
                $query->select(DB::raw('MAX(id_pemeriksaan_lab)'))
                    ->from('pemeriksaan_lab')
                    ->groupBy('id_pemeriksaan');
            })
            ->paginate(5, ['*'], 'page_pemeriksaan');



        // dd($pemeriksaan);
        if ($request->ajax()) {
            return view('petugas.administrator.tabel.lab', compact('pemeriksaan'))->render();
        }

        return view('petugas.lab.periksa-lab', compact('pemeriksaan'));
    }
    // public function labShow($id)
    // {
    //     // Ambil data pemeriksaan dan relasi dengan pasien, poli, dan indikator
    //     $pemeriksaan = DB::table('pemeriksaan_lab')
    //         ->join('pemeriksaan', 'pemeriksaan_lab.id_pemeriksaan', '=', 'pemeriksaan.id_pemeriksaan')
    //         ->join('antrian', 'pemeriksaan.id_antrian', '=', 'antrian.id_antrian')
    //         ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
    //         ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
    //         ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
    //         ->select(
    //             'pemeriksaan_lab.id_pemeriksaan_lab',
    //             'pemeriksaan_lab.kode_lab',
    //             'pasien.nama_pasien as nama_pasien',
    //             'pasien.no_rekam_medis',
    //             'poli.nama_poli',
    //             'pemeriksaan_lab.created_at',
    //             'pemeriksaan_lab.nama_pemeriksaan',
    //             'pemeriksaan_lab.satuan',
    //             'pemeriksaan_lab.nilai_rujukan',
    //             'pemeriksaan_lab.hasil'
    //         )
    //         ->where('pemeriksaan_lab.id_pemeriksaan', $id)
    //         ->get();

    //     // Group data berdasarkan jenis pemeriksaan (jika ada grouping)
    //     $groupedPemeriksaan = $pemeriksaan->groupBy('nama_pemeriksaan');

    //     return view('petugas.lab.periksa-lab-detail', compact('pemeriksaan', 'groupedPemeriksaan'));
    // }

    public function labShow($id)
    {
        // Ambil data pemeriksaan dari database
        $pemeriksaan = DB::table('pemeriksaan_lab')
            ->join('pemeriksaan', 'pemeriksaan_lab.id_pemeriksaan', '=', 'pemeriksaan.id_pemeriksaan')
            ->join('antrian', 'pemeriksaan.id_antrian', '=', 'antrian.id_antrian')
            ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
            ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
            ->select(
                'pemeriksaan.*',
                'pasien.*',
                'poli.*',
                'pemeriksaan_lab.id_pemeriksaan_lab',
                'pemeriksaan_lab.kode_lab',
                'pemeriksaan_lab.created_at',
                'pemeriksaan_lab.nama_pemeriksaan',
                'pemeriksaan_lab.hasil',
                'pemeriksaan_lab.jenis_pemeriksaan'
            )
            ->where('pemeriksaan_lab.id_pemeriksaan', $id)
            ->get();
        // dd($pemeriksaan);
        // Ambil semua data referensi dari tabel nilai_rujukan
        $nilaiRujukan = DB::table('jenis_pemeriksaan_lab')
            ->select('*')
            ->get();

        // Tambahkan data referensi ke masing-masing item
        foreach ($pemeriksaan as $item) {
            $referensi = $nilaiRujukan->firstWhere('nama_pemeriksaan', $item->nama_pemeriksaan);

            $item->satuan = $referensi->satuan ?? '-';
            $item->nilai_rujukan = $referensi->nilai_rujukan ?? '-';
        }



        // Group data berdasarkan jenis pemeriksaan
        $groupedPemeriksaan = $pemeriksaan->groupBy('jenis_pemeriksaan');
        Carbon::setLocale('id');
        $tanggal = Carbon::parse($pemeriksaan->first()->created_at)->translatedFormat('l, d F Y');
        return view('petugas.lab.periksa-lab-detail', compact('pemeriksaan', 'groupedPemeriksaan', 'tanggal'));
    }

    // public function labStore(Request $request)
    // {
    //     // Validasi input
    //     $validatedData = $request->validate([
    //         'hasil.*' => [
    //             'required',
    //             function ($attribute, $value, $fail) {
    //                 // Ekstrak ID pemeriksaan dari nama input (e.g., 'hasil.1')
    //                 $idPemeriksaanLab = explode('.', $attribute)[1];
    //                 $pemeriksaan = PemeriksaanLab::find($idPemeriksaanLab);

    //                 if (!$pemeriksaan) {
    //                     $fail("Pemeriksaan dengan ID {$idPemeriksaanLab} tidak ditemukan.");
    //                 } elseif (is_numeric($pemeriksaan->nilai_rujukan)) {
    //                     // Jika nilai normal berupa angka/rentang angka
    //                     if (!is_numeric($value) || $value < 0) {
    //                         $fail("Hasil untuk {$pemeriksaan->nama_pemeriksaan} harus berupa angka positif.");
    //                     }
    //                 } else {
    //                     // Jika nilai normal berupa teks
    //                     if (is_numeric($value)) {
    //                         $fail("Hasil untuk {$pemeriksaan->nama_pemeriksaan} harus berupa teks.");
    //                     }
    //                 }
    //             }
    //         ],
    //     ]);

    //     // Ambil hasil input dari form
    //     $results = $request->input('hasil');

    //     // Iterasi melalui hasil dan simpan ke database
    //     foreach ($results as $idPemeriksaanLab => $hasil) {
    //         PemeriksaanLab::where('id_pemeriksaan_lab', $idPemeriksaanLab)
    //             ->update(['hasil' => $hasil]);
    //     }

    //     // Redirect dengan pesan sukses
    //     return redirect()->route('lab')->with('success', 'Data pemeriksaan berhasil disimpan.');
    // }

    public function labStore(Request $request)
    {
        // dd($request->all());
        // Validasi input
        // $validatedData = $request->validate([
        //     'hasil.*' => [
        //         'required',
        //         function ($attribute, $value, $fail) {
        //             // Ekstrak ID pemeriksaan dari nama input (e.g., 'hasil.1')
        //             $idPemeriksaanLab = explode('.', $attribute)[1];
        //             $pemeriksaan = PemeriksaanLab::where('id_pemeriksaan_lab', $idPemeriksaanLab)->first();

        //             if (!$pemeriksaan) {
        //                 $fail("Pemeriksaan dengan ID {$idPemeriksaanLab} tidak ditemukan.");
        //             } elseif (is_numeric($pemeriksaan->nilai_rujukan)) {
        //                 if (!is_numeric($value) || $value < 0) {
        //                     $fail("Hasil untuk {$pemeriksaan->nama_pemeriksaan} harus berupa angka positif.");
        //                 }
        //             } else {
        //                 if (is_numeric($value)) {
        //                     $fail("Hasil untuk {$pemeriksaan->nama_pemeriksaan} harus berupa teks.");
        //                 }
        //             }
        //         }
        //     ],
        // ]);

        // Simpan hasil input
        $results = $request->input('hasil');
        foreach ($results as $idPemeriksaanLab => $hasil) {
            PemeriksaanLab::where('id_pemeriksaan_lab', $idPemeriksaanLab)
                ->update(['hasil' => $hasil]);
        }

        return redirect()->route('lab')->with('success', 'Data pemeriksaan berhasil disimpan.');
    }



    public function labCari(Request $request)
    {
        $kodeLab = $request->input('kode_lab'); // Ambil input kode lab dari form

        // Cari data pemeriksaan berdasarkan kode lab
        $pemeriksaan = DB::table('pemeriksaan_lab')
            ->join('pemeriksaan', 'pemeriksaan_lab.id_pemeriksaan', '=', 'pemeriksaan.id_pemeriksaan')
            ->join('antrian', 'pemeriksaan.id_antrian', '=', 'antrian.id_antrian')
            ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
            ->select(
                'pemeriksaan_lab.*',
                'pasien.nama_pasien',
                'pasien.no_rekam_medis'
            )
            ->where('pemeriksaan_lab.kode_lab', $kodeLab)
            ->get();

        // Jika tidak ada data, kembalikan pesan error
        if ($pemeriksaan->isEmpty()) {
            return redirect()->back()->with('error', 'Kode tidak ditemukan.');
        }
        $id = $pemeriksaan->first()->id_pemeriksaan;

        return redirect()->route('lab.show', compact('id', 'kodeLab'));
    }


    public function generatePdf($id)
    {
        // Ambil data pemeriksaan
        // $pemeriksaanLab = DB::table('pemeriksaan_lab')
        //     ->join('pemeriksaan', 'pemeriksaan_lab.id_pemeriksaan', '=', 'pemeriksaan.id_pemeriksaan')
        //     ->join('antrian', 'pemeriksaan.id_antrian', '=', 'antrian.id_antrian')
        //     ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
        //     ->select(
        //         'pemeriksaan_lab.*',
        //         'pasien.no_rekam_medis',
        //         'pasien.nama_pasien',
        //         'pasien.jk_pasien',
        //         'pasien.alamat_pasien',
        //     )
        //     ->where('pemeriksaan.id_pemeriksaan', $id)
        //     ->get();

        $pemeriksaanLab = DB::table('pemeriksaan_lab')
            ->join('jenis_pemeriksaan_lab', 'pemeriksaan_lab.nama_pemeriksaan', '=', 'jenis_pemeriksaan_lab.nama_pemeriksaan')
            ->join('pemeriksaan', 'pemeriksaan_lab.id_pemeriksaan', '=', 'pemeriksaan.id_pemeriksaan')
            ->join('antrian', 'pemeriksaan.id_antrian', '=', 'antrian.id_antrian')
            ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
            ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
            ->join('petugas', 'jadwal.id_petugas', '=', 'petugas.id_petugas')
            ->select('pemeriksaan_lab.nama_pemeriksaan', 'jenis_pemeriksaan_lab.satuan', 'jenis_pemeriksaan_lab.nilai_rujukan', 'pemeriksaan_lab.kode_lab', 'pemeriksaan.*', 'pasien.*', 'poli.*', 'petugas.*')
            ->where('pemeriksaan.id_pemeriksaan', $id)
            ->get();
        // dd($pemeriksaanLab);
        // Ambil data pasien
        $pasien = $pemeriksaanLab->first();
        $groupedPemeriksaan = $pemeriksaanLab->groupBy('jenis_pemeriksaan');

        $pdf = PDF::loadView('petugas.administrator.pdf.lab', compact(
            'pasien',
            'groupedPemeriksaan',
            'pemeriksaanLab'

        ));

        return $pdf->download('hasil_pemeriksaan.pdf');
    }

    public function cetakLab($id, $id_pemeriksaan)
    {
        $lab = PemeriksaanLab::where('kode_lab', $id)->first();
        $pemeriksaan = Pemeriksaan::where('id_pemeriksaan', $id_pemeriksaan)
            ->join('antrian', 'pemeriksaan.id_antrian', '=', 'antrian.id_antrian')
            ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
            ->join('petugas', 'jadwal.id_petugas', '=', 'petugas.id_petugas')
            ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
            ->select('pemeriksaan.*', 'pasien.*', 'poli.*', 'petugas.*')
            ->first();

        $icd = ICD::where('id_icd', $pemeriksaan->id_icd)->first();
        // dd($id);
        $pdf = PDF::loadView('petugas.administrator.pdf.permintaan', compact('lab', 'pemeriksaan', 'icd'));
        return $pdf->download('permintaan-laboratorium.pdf');
    }



}
