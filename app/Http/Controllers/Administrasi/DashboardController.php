<?php

namespace App\Http\Controllers\Administrasi;

use App\Models\ICD;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use DB;
use PDF;

class DashboardController extends Controller
{
    public function index()
    {
        return view('petugas.administrator.dashboard');
    }

    public function dashboard(Request $request)
    {
        // Ambil bulan dari request, default ke bulan sekarang
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        // Validasi input bulan dan tahun
        if (!is_numeric($bulan) || $bulan < 1 || $bulan > 12) {
            abort(400, 'Bulan tidak valid');
        }
        if (!is_numeric($tahun)) {
            abort(400, 'Tahun tidak valid');
        }

        // Query untuk Top 10 Penyakit Berdasarkan ICD
        $dataICD = DB::table('pemeriksaan')
            ->join('icd', 'pemeriksaan.id_icd', '=', 'icd.id_icd')
            ->select(DB::raw('COUNT(pemeriksaan.id_icd) as jumlah_penyakit, icd.nama_penyakit'))
            ->whereMonth('pemeriksaan.tanggal_pemeriksaan', $bulan)
            ->whereYear('pemeriksaan.tanggal_pemeriksaan', $tahun)
            ->groupBy('icd.nama_penyakit')
            ->orderByDesc('jumlah_penyakit')
            ->limit(10)
            ->get();

        // Buat Grafik Bar untuk Top 10 ICD
        $chartICD = $dataICD->isEmpty() ? null : (new LarapexChart)->barChart()
            // ->setTitle('Top 10 Diagnosa')
            ->setSubtitle('Bulan: ' . Carbon::createFromDate($tahun, $bulan, 1)->format('F'))
            ->addData('Jumlah Kasus', $dataICD->pluck('jumlah_penyakit')->toArray())
            ->setXAxis($dataICD->pluck('nama_penyakit')->toArray());

        // Query untuk Grafik Poli Tetap Sama
        $dataPoli = DB::table('antrian')
            ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
            ->select(DB::raw('COUNT(antrian.id_antrian) as jumlah_pasien, poli.nama_poli'))
            ->whereMonth('jadwal.tanggal_praktik', $bulan)
            ->whereYear('jadwal.tanggal_praktik', $tahun)
            ->groupBy('poli.nama_poli')
            ->orderByDesc('jumlah_pasien')
            ->get();

        $chartPoli = $dataPoli->isEmpty() ? null : (new LarapexChart)->barChart()
            // ->setTitle('Kunjungan Pasien ')
            ->setSubtitle('Bulan: ' . Carbon::createFromDate($tahun, $bulan, 1)->format('F'))
            ->addData('Jumlah Pasien', $dataPoli->pluck('jumlah_pasien')->toArray())
            ->setXAxis($dataPoli->pluck('nama_poli')->toArray());

        return view('petugas.administrator.dashboard', compact('chartPoli', 'chartICD'));
    }


    public function generateLaporan(Request $request, $type)
    {
        $bulan = $request->bulan ?? date('n');

        if (!is_numeric($bulan) || $bulan < 1 || $bulan > 12) {
            abort(400, 'Bulan tidak valid');
        }

        switch ($type) {
            case 'icd':
                // Ambil data untuk laporan ICD
                $data = DB::table('pemeriksaan')
                    ->join('icd', 'pemeriksaan.id_icd', '=', 'icd.id_icd')
                    ->select(DB::raw('COUNT(pemeriksaan.id_icd) as jumlah_penyakit, icd.kode_icd, icd.nama_penyakit'))
                    ->whereMonth('pemeriksaan.tanggal_pemeriksaan', $bulan)
                    ->groupBy('icd.kode_icd', 'icd.nama_penyakit')
                    ->orderByDesc('jumlah_penyakit')
                    ->limit(10)
                    ->get();
                $view = 'petugas.administrator.pdf.icd';
                $title = "Laporan 10 Penyakit ICD Paling Sering";
                break;

            case 'kunjungan_poli':
                // Ambil data untuk laporan kunjungan per poli
                $data = DB::table('antrian')
                    ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
                    ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
                    ->select(DB::raw('COUNT(antrian.id_antrian) as jumlah_pasien, poli.nama_poli'))
                    ->whereMonth('jadwal.tanggal_praktik', $bulan)
                    ->groupBy('poli.nama_poli')
                    ->orderByDesc('jumlah_pasien')
                    ->get();


                $view = 'petugas.administrator.pdf.kunjungan_poli';
                $title = "Laporan Kunjungan Pasien per Poli";
                break;

            default:
                abort(404, 'Jenis laporan tidak ditemukan');
        }

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk laporan ini di bulan yang dipilih.');
        }

        // Generate PDF
        $pdf = Pdf::loadView($view, compact('data', 'bulan', 'title'));

        // Unduh PDF
        return $pdf->download("$title - Bulan $bulan.pdf");
    }






}
