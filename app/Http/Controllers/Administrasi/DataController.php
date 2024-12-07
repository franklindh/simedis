<?php

namespace App\Http\Controllers\Administrasi;

use App\Models\ICD;
use App\Models\Jadwal;
use App\Models\Petugas;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class DataController extends Controller
{
    public function indexICD(Request $request)
    {
        $icds = DB::table('icd')->orderBy('created_at', 'desc')->paginate(5, ['*'], 'page_icd');

        if ($request->ajax()) {
            return view('petugas.administrator.tabel.icd', compact('icds'))->render();
        }

        return view('petugas.administrator.data-icd', compact('icds'));
    }
    public function indexPoli(Request $request)
    {
        $polis = DB::table('poli')->orderBy('created_at', 'desc')->paginate(5, ['*'], 'page_poli');

        if ($request->ajax()) {
            return view('petugas.administrator.tabel.poli', compact('polis'))->render();
        }

        return view('petugas.administrator.data-poli', compact('polis'));
    }
    public function indexJadwal(Request $request)
    {
        $petugas = Petugas::where('role', 'dokter')->get();
        $poli = Poli::all();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        // dd($petugas);
        $jadwals = DB::table('jadwal')
            ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
            ->join('petugas', 'jadwal.id_petugas', '=', 'petugas.id_petugas')
            ->select(
                'jadwal.*',
                'poli.nama_poli',
                'petugas.nama_petugas'
            )
            ->whereMonth('jadwal.tanggal_praktik', $currentMonth) // Filter bulan
            ->whereYear('jadwal.tanggal_praktik', $currentYear) // Filter tahun
            ->paginate(5, ['*'], 'page_jadwal');


        if ($request->ajax()) {
            return view('petugas.administrator.tabel.jadwal', compact('jadwals'))->render();
        }

        return view('petugas.administrator.data-jadwal', compact('jadwals', 'petugas', 'poli'));
    }

    public function storeICD(Request $request)
    {
        $request->validate([
            'kode_icd' => 'required',
            'nama_penyakit' => 'required',
        ]);

        ICD::create([
            'kode_icd' => $request->kode_icd,
            'nama_penyakit' => $request->nama_penyakit,
        ]);

        return redirect()->route('data.icd')->with('success', 'Data ICD berhasil ditambahkan');
    }

    public function storePoli(Request $request)
    {
        $request->validate([
            'nama_poli' => 'required',
        ]);

        Poli::create([
            'nama_poli' => $request->nama_poli,
        ]);

        return redirect()->route('data.poli')->with('success', 'Data Poli berhasil ditambahkan');
    }

    // public function storeJadwal(Request $request)
    // {
    //     // dd($request->all());
    //     $validator = Validator::make($request->all(), [
    //         'id_petugas' => 'required|exists:petugas,id_petugas',
    //         'id_poli' => 'required|exists:poli,id_poli',
    //         'hari' => 'required|array',
    //         'hari.*' => 'integer|between:1,7',
    //         'waktu_mulai' => 'required|date_format:H:i',
    //         'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput(); // Menyimpan input pengguna agar tidak hilang
    //     }

    //     $hariDipilih = $request->hari; // Hari yang dipilih (1 = Senin, ..., 7 = Minggu)
    //     $tanggalSekarang = Carbon::today(); // Mulai dari hari ini
    //     $tanggalBerikutnya = $tanggalSekarang->copy()->addDays(7); // Sampai satu minggu ke depan

    //     $tanggalYangDibuat = [];

    //     // Loop selama seminggu untuk mencari tanggal sesuai hari yang dipilih
    //     while ($tanggalSekarang->lte($tanggalBerikutnya)) {
    //         if (in_array($tanggalSekarang->dayOfWeekIso, $hariDipilih)) {
    //             // Periksa apakah jadwal sudah ada
    //             $existingJadwal = Jadwal::where('id_petugas', $request->id_petugas)
    //                 ->where('id_poli', $request->id_poli)
    //                 ->where('tanggal_praktik', $tanggalSekarang->format('Y-m-d'))
    //                 ->where('waktu_mulai', $request->waktu_mulai)
    //                 ->where('waktu_selesai', $request->waktu_selesai)
    //                 ->exists();

    //             if (!$existingJadwal) {
    //                 // Tambahkan jadwal jika belum ada
    //                 Jadwal::create([
    //                     'id_petugas' => $request->id_petugas,
    //                     'id_poli' => $request->id_poli,
    //                     'tanggal_praktik' => $tanggalSekarang->format('Y-m-d'),
    //                     'waktu_mulai' => $request->waktu_mulai,
    //                     'waktu_selesai' => $request->waktu_selesai,
    //                 ]);

    //                 $tanggalYangDibuat[] = $tanggalSekarang->format('Y-m-d');
    //             }
    //             // dd('Tidak ada jadwal baru yang dibuat karena sudah terdaftar1.');
    //         }
    //         // dd('Tidak ada jadwal baru yang dibuat karena sudah terdaftar2.');
    //         // Tambahkan satu hari
    //         $tanggalSekarang->addDay();
    //     }

    //     if (empty($tanggalYangDibuat)) {

    //         return redirect()->route('data.jadwal')->with('error', 'Tidak ada jadwal baru yang dibuat karena sudah terdaftar.');
    //     }

    //     return redirect()->route('data.jadwal')->with('success', 'Jadwal berhasil dibuat untuk tanggal: ' . implode(', ', $tanggalYangDibuat));
    // }
    public function storeJadwal(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal_praktik' => 'required|date',
            'id_poli' => 'required|exists:poli,id_poli',
            'id_petugas' => 'required|exists:petugas,id_petugas',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        // Cek apakah jadwal sudah ada pada tanggal dan poli yang sama
        $existingJadwal = Jadwal::where('tanggal_praktik', $request->tanggal_praktik)
            ->where('id_poli', $request->id_poli)
            ->where('id_petugas', $request->id_petugas)
            ->where(function ($query) use ($request) {
                $query->whereBetween('waktu_mulai', [$request->waktu_mulai, $request->waktu_selesai])
                    ->orWhereBetween('waktu_selesai', [$request->waktu_mulai, $request->waktu_selesai]);
            })
            ->exists();

        if ($existingJadwal) {
            return redirect()->back()->withErrors('Jadwal sudah ada pada waktu dan tanggal yang dipilih.');
        }

        // Simpan jadwal baru
        Jadwal::create($validatedData);

        return redirect()->route('data.jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
    }
    public function updateJadwal(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'id_poli' => 'required',
            'id_petugas' => 'required',
            'tanggal_praktik' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function updateICD(Request $request, $id)
    {
        $request->validate([
            'kode_icd' => 'required|string',
            'nama_penyakit' => 'required|string|max:255',
        ]);

        $icd = ICD::findOrFail($id);
        $icd->update($request->all());

        return redirect()->back()->with('success', 'Data ICD berhasil diperbarui.');
    }

    public function updatePoli(Request $request, $id)
    {
        $request->validate([
            'nama_poli' => 'required|string|max:255',
        ]);

        $poli = Poli::findOrFail($id);
        $poli->update($request->all());

        return redirect()->back()->with('success', 'Data Poli berhasil diperbarui.');
    }

    public function destroyPoli($id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete();

        return redirect()->back()->with('success', 'Data Poli berhasil dihapus.');
    }

    public function destroyICD($id)
    {
        $icd = ICD::findOrFail($id);
        $icd->delete();

        return redirect()->back()->with('success', 'Data ICD berhasil dihapus.');
    }
    public function destroyJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->back()->with('success', 'Data Jadwal berhasil dihapus.');
    }

    public function nonaktifPoli($id)
    {
        $poli = Poli::findOrFail($id);
        $poli->status_poli = 'nonaktif';

        // // Nonaktifkan jadwal terkait
        // Jadwal::where('id_poli', $poli->id_poli)->update(['status' => 'nonaktif']);

        $poli->save();

        return redirect()->route('data.poli')->with('success', 'Poli berhasil dinonaktifkan.');
    }

    public function aktifPoli($id)
    {
        $poli = Poli::findOrFail($id);
        $poli->status_poli = 'aktif';

        // // Aktifkan jadwal terkait
        // Jadwal::where('id_poli', $poli->id_poli)->update(['status' => 'aktif']);

        $poli->save();

        return redirect()->route('data.poli')->with('success', 'Poli berhasil diaktifkan.');
    }
    public function nonaktifICD($id)
    {
        $poli = ICD::findOrFail($id);
        $poli->status_icd = 'nonaktif';

        // // Nonaktifkan jadwal terkait
        // Jadwal::where('id_poli', $poli->id_poli)->update(['status' => 'nonaktif']);

        $poli->save();

        return redirect()->route('data.icd')->with('success', 'ICD berhasil dinonaktifkan.');
    }

    public function aktifICD($id)
    {
        $poli = ICD::findOrFail($id);
        $poli->status_icd = 'aktif';

        // // Aktifkan jadwal terkait
        // Jadwal::where('id_poli', $poli->id_poli)->update(['status' => 'aktif']);

        $poli->save();

        return redirect()->route('data.icd')->with('success', 'ICD berhasil diaktifkan.');
    }







}
