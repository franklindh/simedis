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
        // Validasi data input
        $validatedData = $request->validate([
            'keluhan' => 'required',
            'riwayat' => 'required',
            'keadaan_umum' => 'required',
            'berat_badan' => 'required|numeric',
            'suhu_badan' => 'required|numeric',
            'tekanan_darah' => 'required',
            'nadi' => 'required|numeric',
            // 'tanggal_pemeriksaan_lab' => 'nullable|date',
            // 'jenis_pemeriksaan_lab' => 'nullable|string|max:255',
            // 'hasil_pemeriksaan_lab' => 'nullable|string|max:255',
            // 'tanggal_pemeriksaan_non_lab' => 'nullable|date',
            // 'jenis_pemeriksaan_non_lab' => 'nullable|string|max:255',
            // 'hasil_pemeriksaan_non_lab' => 'nullable|string|max:255',
            // 'dokumen_pemeriksaan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Cek apakah data pemeriksaan sudah ada
        $existingPemeriksaan = Pemeriksaan::where('id_antrian', $request->idAntrian)->first();

        // Jika ada file dokumen, simpan ke storage
        $dokumenPath = $existingPemeriksaan ? $existingPemeriksaan->dokumen_pemeriksaan : null; // Pertahankan nilai lama
        if ($request->hasFile('dokumen_pemeriksaan')) {
            $dokumenPath = $request->file('dokumen_pemeriksaan')->store('dokumen_pemeriksaan', 'public');
        }
        $pasienRM = DB::table('antrian')
            ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
            ->select('pasien.no_rekam_medis')
            ->where('antrian.id_antrian', $request->idAntrian)
            ->first();
        // $kodeLab = 'LAB' . '-' . Carbon::now()->format('Ymd') . '-' . $pasienRM->no_rekam_medis;
        $kodeLoinc = [
            // Hematologi
            [
                'nama_pemeriksaan' => 'Haemoglobin',
                'kode_loinc' => '718-7',
                'deskripsi_loinc' => 'Hemoglobin [Mass/volume] in Blood'
            ],
            [
                'nama_pemeriksaan' => 'Leukosit',
                'kode_loinc' => '6690-2',
                'deskripsi_loinc' => 'Leukocytes [#/volume] in Blood'
            ],
            [
                'nama_pemeriksaan' => 'Trombosit',
                'kode_loinc' => '777-3',
                'deskripsi_loinc' => 'Platelets [#/volume] in Blood'
            ],

            // Kimia Klinik
            [
                'nama_pemeriksaan' => 'Glukosa Sewaktu',
                'kode_loinc' => '2339-0',
                'deskripsi_loinc' => 'Glucose [Mass/volume] in Blood'
            ],
            [
                'nama_pemeriksaan' => 'Glukosa 2 Jam PP',
                'kode_loinc' => '2345-7',
                'deskripsi_loinc' => 'Glucose 2 hours post 75 g glucose'
            ],
            [
                'nama_pemeriksaan' => 'Glukosa Puasa',
                'kode_loinc' => '1558-6',
                'deskripsi_loinc' => 'Glucose [Mass/volume] in Serum or Plasma'
            ],
            [
                'nama_pemeriksaan' => 'Asam Urat',
                'kode_loinc' => '3084-1',
                'deskripsi_loinc' => 'Uric acid [Mass/volume] in Serum or Plasma'
            ],
            [
                'nama_pemeriksaan' => 'Kolesterol',
                'kode_loinc' => '2093-3',
                'deskripsi_loinc' => 'Cholesterol [Mass/volume] in Serum or Plasma'
            ],
            [
                'nama_pemeriksaan' => 'Trigliserida',
                'kode_loinc' => '2571-8',
                'deskripsi_loinc' => 'Triglyceride [Mass/volume] in Serum or Plasma'
            ],

            // Urine
            [
                'nama_pemeriksaan' => 'Warna',
                'kode_loinc' => '5778-6',
                'deskripsi_loinc' => 'Color of Urine'
            ],
            [
                'nama_pemeriksaan' => 'pH',
                'kode_loinc' => '2756-5',
                'deskripsi_loinc' => 'pH of Urine'
            ],
            [
                'nama_pemeriksaan' => 'Berat Jenis',
                'kode_loinc' => '5811-5',
                'deskripsi_loinc' => 'Specific gravity of Urine'
            ],
            [
                'nama_pemeriksaan' => 'Protein',
                'kode_loinc' => '2888-6',
                'deskripsi_loinc' => 'Protein [Presence] in Urine by Test strip'
            ],
            [
                'nama_pemeriksaan' => 'Glukosa',
                'kode_loinc' => '5792-7',
                'deskripsi_loinc' => 'Glucose [Presence] in Urine by Test strip'
            ]
        ];


        // Pemeriksaan yang dipilih (dari request)
        $pemeriksaanDipilih = $request->pemeriksaan_lab; // Misalnya: ["Glukosa Sewaktu", "Glukosa 2 Jam PP"]

        // // Filter kode LOINC berdasarkan pemeriksaan yang dipilih
        // $kodeLoincDipilih = array_filter($kodeLoinc, function ($item) use ($pemeriksaanDipilih) {
        //     return in_array($item['nama_pemeriksaan'], $pemeriksaanDipilih);
        // });

        // // Generate kode lab
        // $kodeLab = $request->jenis_pemeriksaan_lab
        //     ? 'LAB-' . Carbon::now()->format('Ymd') . '-' . $pasienRM->no_rekam_medis
        //     : null;

        // // Tambahkan kode LOINC ke kode lab
        // $kodeLoincString = implode('-', array_column($kodeLoincDipilih, 'kode_loinc'));
        // $kodeLab = $kodeLab ? $kodeLab . '-' . $kodeLoincString : null;
        // // $kodeLab = $request->jenis_pemeriksaan_lab ? 'LAB' . '-' . Carbon::now()->format('Ymd') . '-' . $pasienRM->no_rekam_medis : null;

        // $request->jenis_pemeriksaan_lab ? 'LAB' . '-' . Carbon::now()->format('Ymd') . '-' . $pasienRM->no_rekam_medis : null;
        $kodeLab = $request->jenis_pemeriksaan_lab ? mt_rand(10000, 99999) : null;
        // dd($kodeLab);

        // Data yang akan disimpan atau diperbarui
        $data = [
            'id_icd' => $request->icd,
            'keluhan' => $validatedData['keluhan'],
            'riwayat_penyakit' => $validatedData['riwayat'],
            'keadaan_umum' => $validatedData['keadaan_umum'],
            'berat_badan' => $validatedData['berat_badan'],
            'suhu' => $validatedData['suhu_badan'],
            'tekanan_darah' => $validatedData['tekanan_darah'],
            'nadi' => $validatedData['nadi'],
            'tindakan' => $request->tindakan ?? null,

            'kode_lab' => $kodeLab,
            'jenis_pemeriksaan_lab' => json_encode($request->jenis_pemeriksaan_lab) ?? null,
            'sub_pemeriksaan_lab' => json_encode($request->pemeriksaan_lab) ?? null,
            'hasil_pemeriksaan_lab' => json_encode($request->hasil_pemeriksaan_lab) ?? null,
            'dokumen_hasil_pemeriksaan_lab' => $dokumenPath,
            'status_pemeriksaan_lab' => 'Pending',

            'updated_at' => Carbon::now(),
        ];

        // Tentukan status berdasarkan input ICD dan Tindakan
        $status = ($request->icd && $request->tindakan) ? 'Selesai' : 'Menunggu Diagnosis';

        if ($existingPemeriksaan) {
            // Update data pemeriksaan jika sudah ada
            $existingPemeriksaan->update($data);

            // Update status antrian
            Antrian::where('id_antrian', $request->idAntrian)->update([
                'status' => $status,
                'updated_at' => Carbon::now(),
            ]);

            $message = 'Data pemeriksaan berhasil diperbarui.';
        } else {
            // Tambahkan data untuk pemeriksaan baru
            $data['id_antrian'] = $request->idAntrian;
            $data['tanggal_pemeriksaan'] = Carbon::now();
            $data['created_at'] = Carbon::now();

            // Simpan pemeriksaan baru
            Pemeriksaan::create($data);

            // Update status antrian
            Antrian::where('id_antrian', $request->idAntrian)->update([
                'status' => $status,
                'updated_at' => Carbon::now(),
            ]);

            $message = 'Pemeriksaan pasien berhasil disimpan.';
        }

        $existingPemeriksaan = Pemeriksaan::latest()->first();

        // Loop melalui setiap pemeriksaan_lab
        foreach ($request['pemeriksaan_lab'] as $key => $pemeriksaan) {
            PemeriksaanLab::create([
                'kode_lab' => $kodeLab,
                'jenis_pemeriksaan' => $request['jenis_pemeriksaan_lab'][0] ?? null, // Pilih jenis pertama, jika ada
                'nama_pemeriksaan' => $pemeriksaan,

                // 'satuan' => 'mg/dl', // Atur sesuai kebutuhan
                // 'nilai_rujukan' => '70-110', // Atur sesuai kebutuhan
                'hasil' => null, // Biarkan null jika belum ada hasil
                'dokumen_hasil_pemeriksaan_lab' => null, // Optional
                'id_pemeriksaan' => $existingPemeriksaan->id_pemeriksaan
            ]);
        }


        // Redirect dengan pesan sukses
        return redirect()->route('pemeriksaan')->with('success', $message);
    }


    // public function show($id_antrian)
    // {
    //     // dd($id_antrian);
    //     $pemeriksaan = Pemeriksaan::where('id_antrian', $id_antrian)->first();
    //     // dd($pemeriksaan);
    //     $idAntrian = $id_antrian;
    //     // dd($idAntrian);
    //     // dd($pemeriksaan == null);
    //     if (!$pemeriksaan === null) {
    //         // return redirect()->route('pemeriksaan')->with('error', 'Data pemeriksaan tidak ditemukan.');
    //         // dd($pemeriksaan);
    //         return view('petugas.poliklinik-dokter.periksa-detail', compact('pemeriksaan', 'idAntrian'));
    //     }

    //     // $kodeIcd = DB::table('icd')->where('status', 'aktif')->get();
    //     $kodeIcd = ICD::where('status_icd', 'aktif')->get();
    //     // dd($pemeriksaan);
    //     // dd($kodeIcd);
    //     return view('petugas.poliklinik-dokter.periksa-detail', compact('pemeriksaan', 'idAntrian', 'kodeIcd'));
    // }

    public function show($id_antrian)
    {
        $user = Auth::guard('petugas')->user();
        $role = $user->role;

        // Ambil data pemeriksaan
        $pemeriksaan = Pemeriksaan::where('id_antrian', $id_antrian)->first();

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

            return view('petugas.poliklinik-dokter.periksa-detail', compact('pemeriksaan', 'idAntrian', 'kodeIcd', 'role', 'data'));
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

        return view('petugas.poliklinik-dokter.periksa-detail', compact('pemeriksaan', 'idAntrian', 'kodeIcd', 'role', 'data', 'pemeriksaanLab'));
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
                'pemeriksaan_lab.satuan',
                'pemeriksaan_lab.nilai_rujukan',
                'pemeriksaan_lab.hasil',
                'pemeriksaan_lab.jenis_pemeriksaan'
            )
            ->where('pemeriksaan_lab.id_pemeriksaan', $id)
            ->get();
        // dd($pemeriksaan);
        // Ambil semua data referensi dari tabel nilai_rujukan
        $nilaiRujukan = DB::table('nilai_rujukan')
            ->select('nama_pemeriksaan', 'satuan', 'nilai_rujukan', 'kriteria')
            ->get();

        //dd($nilaiRujukan);
        // dd($pemeriksaan);
        // Tambahkan satuan dan nilai rujukan ke masing-masing item pemeriksaan
        // foreach ($pemeriksaan as $item) {
        //     $referensi = $nilaiRujukan->get($item->nama_pemeriksaan);
        //     $item->satuan = $referensi->satuan ?? '-';
        //     $item->nilai_rujukan = $referensi->nilai_rujukan ?? '-';
        // }

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

    public function labStore(Request $request)
    {
        $results = $request->input('hasil'); // Ambil hasil input dari form

        // Iterasi melalui hasil dan simpan ke database
        foreach ($results as $idPemeriksaanLab => $hasil) {
            PemeriksaanLab::where('id_pemeriksaan_lab', $idPemeriksaanLab)
                ->update(['hasil' => $hasil]);
        }

        // Redirect dengan pesan sukses
        // return redirect()->route('lab.show', ['id' => $request->input('id_pemeriksaan')])
        //     ->with('success', 'Hasil pemeriksaan berhasil disimpan.');
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
        $pemeriksaanLab = DB::table('pemeriksaan_lab')
            ->join('pemeriksaan', 'pemeriksaan_lab.id_pemeriksaan', '=', 'pemeriksaan.id_pemeriksaan')
            ->join('antrian', 'pemeriksaan.id_antrian', '=', 'antrian.id_antrian')
            ->join('pasien', 'antrian.id_pasien', '=', 'pasien.id_pasien')
            ->select(
                'pemeriksaan_lab.*',
                'pasien.no_rekam_medis',
                'pasien.nama_pasien',
                'pasien.jk_pasien',
                'pasien.alamat_pasien',
            )
            ->where('pemeriksaan.id_pemeriksaan', $id)
            ->get();

        // Ambil data pasien
        $pasien = $pemeriksaanLab->first();
        $groupedPemeriksaan = $pemeriksaanLab->groupBy('jenis_pemeriksaan');

        // Data tambahan
        $kode_lab = 'LAB-' . now()->format('Ymd') . '-1234';
        $tanggal_pemeriksaan = now()->format('d-m-Y');
        $petugas = 'Nama Petugas';
        $asal_klinik = 'Puskesmas X';

        $pdf = PDF::loadView('petugas.administrator.pdf.lab', compact(
            'pasien',
            'kode_lab',
            'tanggal_pemeriksaan',
            'petugas',
            'asal_klinik',
            'groupedPemeriksaan'
        ));

        return $pdf->download('hasil_pemeriksaan.pdf');
    }


}
