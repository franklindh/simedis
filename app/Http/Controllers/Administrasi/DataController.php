<?php

namespace App\Http\Controllers\Administrasi;

use App\Models\ICD;
use App\Models\Jadwal;
use App\Models\Petugas;
use App\Models\Poli;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        // dd($petugas);
        $jadwals = DB::table('jadwal')
            ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
            ->join('petugas', 'jadwal.id_petugas', '=', 'petugas.id_petugas')
            ->select(
                'jadwal.*',
                'poli.nama_poli',
                'petugas.nama_petugas'
            )
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

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'id_petugas' => 'required',
            'id_poli' => 'required',
            'tanggal_praktik' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        Jadwal::create([
            'id_petugas' => $request->id_petugas,
            'id_poli' => $request->id_poli,
            'tanggal_praktik' => $request->tanggal_praktik,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return redirect()->route('data.jadwal')->with('success', 'Data Jadwal berhasil ditambahkan');
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
        $poli->status = 'nonaktif';

        // // Nonaktifkan jadwal terkait
        // Jadwal::where('id_poli', $poli->id_poli)->update(['status' => 'nonaktif']);

        $poli->save();

        return redirect()->route('data.poli')->with('success', 'Poli berhasil dinonaktifkan.');
    }

    public function aktifPoli($id)
    {
        $poli = Poli::findOrFail($id);
        $poli->status = 'aktif';

        // // Aktifkan jadwal terkait
        // Jadwal::where('id_poli', $poli->id_poli)->update(['status' => 'aktif']);

        $poli->save();

        return redirect()->route('data.poli')->with('success', 'Poli berhasil diaktifkan.');
    }
    public function nonaktifICD($id)
    {
        $poli = ICD::findOrFail($id);
        $poli->status = 'nonaktif';

        // // Nonaktifkan jadwal terkait
        // Jadwal::where('id_poli', $poli->id_poli)->update(['status' => 'nonaktif']);

        $poli->save();

        return redirect()->route('data.icd')->with('success', 'ICD berhasil dinonaktifkan.');
    }

    public function aktifICD($id)
    {
        $poli = ICD::findOrFail($id);
        $poli->status = 'aktif';

        // // Aktifkan jadwal terkait
        // Jadwal::where('id_poli', $poli->id_poli)->update(['status' => 'aktif']);

        $poli->save();

        return redirect()->route('data.icd')->with('success', 'ICD berhasil diaktifkan.');
    }







}
