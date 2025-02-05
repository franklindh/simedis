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
        $icds = ICD::orderBy('created_at', 'desc')->paginate(5, ['*'], 'page_icd');

        if ($request->ajax()) {
            return view('petugas.administrator.tabel.icd', compact('icds'))->render();
        }

        return view('petugas.administrator.data-icd', compact('icds'));
    }
    public function indexPoli(Request $request)
    {
        $polis = Poli::paginate(5, ['*'], 'page_poli');

        if ($request->ajax()) {
            return view('petugas.administrator.tabel.poli', compact('polis'))->render();
        }

        return view('petugas.administrator.data-poli', compact('polis'));
    }
    public function indexJadwal(Request $request)
    {
        // Jadwal::where('tanggal_praktik', '<', Carbon::today())->delete();

        $petugas = Petugas::where('role', 'dokter')->get();
        $poli = Poli::where('status_poli', 'aktif')->get();

        // $currentMonth = Carbon::now()->month;
        // $currentYear = Carbon::now()->year;

        $currentDate = Carbon::today(); // Mendapatkan tanggal hari ini
        // $jadwals = Jadwal::join('poli', 'jadwal.id_poli', '=', 'poli.id_poli') // Join dengan tabel poli
        //     ->join('petugas', 'jadwal.id_petugas', '=', 'petugas.id_petugas') // Join dengan tabel petugas
        //     ->select(
        //         'jadwal.*',
        //         'poli.nama_poli',
        //         'petugas.nama_petugas'
        //     )
        //     ->paginate(5, ['*'], 'page_jadwal');
        $jadwals = Jadwal::join('poli', 'jadwal.id_poli', '=', 'poli.id_poli') // Join dengan tabel poli
            ->join('petugas', 'jadwal.id_petugas', '=', 'petugas.id_petugas') // Join dengan tabel petugas
            ->select(
                'jadwal.*',
                'poli.nama_poli',
                'petugas.nama_petugas'
            )
            ->whereDate('jadwal.tanggal_praktik', $currentDate) // Filter untuk jadwal hari ini
            ->paginate(5, ['*'], 'page_jadwal');



        if ($request->ajax()) {
            return view('petugas.administrator.tabel.jadwal', compact('jadwals'))->render();
        }

        return view('petugas.administrator.data-jadwal', compact('jadwals', 'petugas', 'poli'));
    }

    public function storeICD(Request $request)
    {

        $request->validate([
            'kode_icd' => 'required|unique:icd,kode_icd',
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
            'nama_poli' => 'required|unique:poli,nama_poli',
        ]);

        Poli::create([
            'nama_poli' => $request->nama_poli,
        ]);

        return redirect()->route('data.poli')->with('success', 'Data Poli berhasil ditambahkan');
    }

    // public function storeJadwal(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'tanggal_praktik' => 'required|date',
    //         'id_poli' => 'required|exists:poli,id_poli',
    //         'id_petugas' => 'required|exists:petugas,id_petugas',
    //         'waktu_mulai' => 'required|date_format:H:i',
    //         'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
    //     ]);

    //     // Cek apakah jadwal sudah ada pada tanggal dan poli yang sama
    //     $existingJadwal = Jadwal::where('tanggal_praktik', $request->tanggal_praktik)
    //         ->where('id_poli', $request->id_poli)
    //         ->where('id_petugas', $request->id_petugas)
    //         ->where(function ($query) use ($request) {
    //             $query->whereBetween('waktu_mulai', [$request->waktu_mulai, $request->waktu_selesai])
    //                 ->orWhereBetween('waktu_selesai', [$request->waktu_mulai, $request->waktu_selesai]);
    //         })
    //         ->exists();

    //     if ($existingJadwal) {
    //         return redirect()->back()->withErrors('Jadwal sudah ada pada waktu dan tanggal yang dipilih.');
    //     }

    //     // Simpan jadwal baru
    //     Jadwal::create($validatedData);

    //     return redirect()->route('data.jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
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

        // Cek apakah dokter sudah memiliki jadwal pada tanggal yang sama
        $existingJadwal = Jadwal::where('tanggal_praktik', $request->tanggal_praktik)
            ->where('id_petugas', $request->id_petugas)
            ->exists();

        if ($existingJadwal) {
            return redirect()->back()->with('error', 'Dokter sudah memiliki jadwal pada tanggal yang dipilih.');
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
        // dd($request->all());
        $request->validate([
            'nama_penyakit' => 'required|string|max:255',
        ]);

        $icd = ICD::findOrFail($id);
        $icd->update($request->all());

        return redirect()->back()->with('success', 'Data ICD berhasil diperbarui.');
    }

    public function updatePoli(Request $request, $id)
    {
        $request->validate([
            'nama_poli' => 'required|max:255',
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
