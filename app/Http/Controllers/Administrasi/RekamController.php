<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Illuminate\Http\Request;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\ICD;



class RekamController extends Controller
{
    public function index()
    {
        $pasiens = DB::table('pasien')->get();

        return view('petugas.administrator.rekam', compact('pasiens'));
    }

    public function cari(Request $request)
    {
        $idPasien = $request->id_pasien;

        $pasienDetail = DB::table('antrian')
            ->join('pemeriksaan', 'antrian.id_antrian', 'pemeriksaan.id_antrian')
            ->join('pasien', 'antrian.id_pasien', 'pasien.id_pasien')
            ->join('jadwal', 'antrian.id_jadwal', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', 'poli.id_poli')
            ->join('petugas', 'jadwal.id_petugas', 'petugas.id_petugas')
            ->select('pemeriksaan.*', 'antrian.*', 'pasien.*', 'jadwal.*', 'poli.*', 'petugas.*')
            ->where('antrian.id_pasien', $idPasien)
            ->orderBy('pemeriksaan.tanggal_pemeriksaan', 'desc')
            ->paginate(5);

        if ($pasienDetail->isEmpty()) {
            return redirect()->route('rekam')->with('error', 'Pasien belum melakukan pemeriksaan');
        } else {
            $pasiens = DB::table('pasien')->get();

            $tanggalPemeriksaan = $pasienDetail[0]->tanggal_pemeriksaan;
            Carbon::setLocale('id');
            $tanggal = Carbon::parse($tanggalPemeriksaan)->translatedFormat('l, d F Y');

            $tanggalLahir = $pasienDetail[0]->tanggal_lahir_pasien;
            Carbon::setLocale('id');
            $tanggalLahir = Carbon::parse($tanggalLahir)->translatedFormat('d F Y');

            $jenisKelamin = $pasienDetail[0]->jk_pasien;
            $jenisKelamin = ($jenisKelamin == 'L') ? 'Laki-laki' : 'Perempuan';

            $umur = Carbon::parse($pasienDetail[0]->tanggal_lahir_pasien)->age;

            return view('petugas.administrator.rekam', compact('pasiens', 'pasienDetail', 'jenisKelamin', 'tanggal', 'tanggalLahir', 'umur'));
        }
    }

    public function detailByTanggal($id_pasien, $tanggal)
    {
        $dataRekamMedisDetail = DB::table('pemeriksaan')
            ->join('antrian', 'pemeriksaan.id_antrian', 'antrian.id_antrian')
            ->join('pasien', 'antrian.id_pasien', 'pasien.id_pasien')
            ->join('jadwal', 'antrian.id_jadwal', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', 'poli.id_poli')
            ->join('petugas', 'jadwal.id_petugas', 'petugas.id_petugas')
            ->select('pemeriksaan.*', 'antrian.*', 'pasien.*', 'jadwal.*', 'poli.*', 'petugas.*')
            ->where('pasien.id_pasien', $id_pasien)
            ->where('pemeriksaan.tanggal_pemeriksaan', $tanggal)
            ->first();

        $icd = ICD::find($dataRekamMedisDetail->id_icd);
        if ($dataRekamMedisDetail == null) {
            return redirect()->back()->with('error', 'Data diagnosis tidak ditemukan');
        }

        $tanggalPemeriksaan = $dataRekamMedisDetail->tanggal_pemeriksaan;
        Carbon::setLocale('id');
        $tanggal = Carbon::parse($tanggalPemeriksaan)->translatedFormat('l, d F Y');

        $umur = Carbon::parse($dataRekamMedisDetail->tanggal_lahir_pasien)->age;

        return view('petugas.administrator.detail-rekam-kunjungan', compact('dataRekamMedisDetail', 'tanggal', 'umur', 'icd'));


    }

    public function cetak(Request $request)
    {
        $tanggalPeriode = explode(' to ', $request->input('tanggal_periode'));

        $startDate = $tanggalPeriode[0];
        $endDate = $tanggalPeriode[1];
        // dd($startDate);
        // $pasienDetail = DB::table('pemeriksaan')
        //     ->join('pasien', 'pemeriksaan.nik_pasien', '=', 'pasien.nik')
        //     ->join('petugas', 'pemeriksaan.id_petugas', '=', 'petugas.id')
        //     ->select('pemeriksaan.*', 'pasien.*', 'petugas.*')
        //     ->whereBetween('pemeriksaan.tanggal_pemeriksaan', [$startDate, $endDate])
        //     ->orderBy('pemeriksaan.tanggal_pemeriksaan', 'asc')
        //     ->get();

        $pasienDetail = DB::table('diagnosis')
            ->join('pemeriksaan', 'diagnosis.id_pemeriksaan', '=', 'pemeriksaan.id')
            ->join('pasien', 'pemeriksaan.nik_pasien', '=', 'pasien.nik')
            ->join('petugas', 'pemeriksaan.id_petugas', '=', 'petugas.id')
            ->select('pemeriksaan.*', 'pasien.*', 'petugas.*', 'diagnosis.*')
            ->whereBetween('pemeriksaan.tanggal_pemeriksaan', [$startDate, $endDate])
            ->orderBy('pemeriksaan.tanggal_pemeriksaan', 'asc')
            ->get();
        // dd($pasienDetail);
        // Ambil data diri pasien hanya sekali
        $pasienData = $pasienDetail->first();

        // Pisahkan data anamnesis dan diagnosis per tanggal
        $groupedData = $pasienDetail->groupBy('tanggal_pemeriksaan');
        // dd($pasienDetail);

        $pdf = PDF::loadView('petugas.administrator.pdf.rekam', compact('pasienData', 'groupedData', 'startDate', 'endDate'));
        return $pdf->stream('Rekam_Medis.pdf');
    }
    public function cetakPDF($id)
    {
        $dataRekamMedisDetail = DB::table('pemeriksaan')
            ->join('antrian', 'pemeriksaan.id_antrian', 'antrian.id_antrian')
            ->join('pasien', 'antrian.id_pasien', 'pasien.id_pasien')
            ->join('jadwal', 'antrian.id_jadwal', 'antrian.id_jadwal')
            ->join('poli', 'jadwal.id_poli', 'poli.id_poli')
            ->join('petugas', 'jadwal.id_petugas', 'jadwal.id_petugas')
            ->join('icd', 'pemeriksaan.id_icd', 'icd.id_icd')
            ->select('pemeriksaan.*', 'antrian.*', 'pasien.*', 'jadwal.*', 'poli.*', 'petugas.*', 'icd.*')
            ->where('pemeriksaan.id_pemeriksaan', $id)
            ->first();

        $jenisKelamin = $dataRekamMedisDetail->jk_pasien;
        $jk = ($jenisKelamin == 'L') ? 'Laki-laki' : 'Perempuan';

        $umur = Carbon::parse($dataRekamMedisDetail->tanggal_lahir_pasien)->age;

        $tanggalPemeriksaan = $dataRekamMedisDetail->tanggal_pemeriksaan;
        Carbon::setLocale('id');
        $tanggal = Carbon::parse($tanggalPemeriksaan)->translatedFormat('l, d F Y');
        // $tanggal = Carbon::parse($tanggalPemeriksaan)->translatedFormat('l, d F Y');
        // dd($tanggal);
        $tanggalLahir = $dataRekamMedisDetail->tanggal_lahir_pasien;
        Carbon::setLocale('id');
        $tanggalLahir = Carbon::parse($tanggalLahir)->translatedFormat('d F Y');

        $pdf = PDF::loadView('petugas.administrator.pdf.resume-medis', compact('dataRekamMedisDetail', 'umur', 'jk', 'tanggal', 'tanggalLahir'));

        return $pdf->download("resume-medis-{$dataRekamMedisDetail->nama_pasien}.pdf");
        // return view('petugas.administrator.pdf.resume-medis', compact('dataRekamMedisDetail', 'umur', 'jk', 'diagnosis'));
    }
}
