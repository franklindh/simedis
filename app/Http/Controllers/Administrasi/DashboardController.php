<?php

namespace App\Http\Controllers\Administrasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('petugas.administrator.dashboard');
    }

    public function dashboard()
    {
        // Mengambil data kunjungan berdasarkan bulan dan poli
        $kunjungan = DB::table('antrian')
            ->join('jadwal', 'antrian.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
            ->select(
                DB::raw('COUNT(antrian.id_antrian) as total'),
                DB::raw('MONTHNAME(antrian.created_at) as bulan'),
                'poli.nama_poli'
            )
            ->groupBy('bulan', 'poli.nama_poli')
            ->orderBy(DB::raw('MONTH(antrian.created_at)'))
            ->get();

        // Siapkan array untuk label bulan dan data per poli
        $labels = [];
        $dataPerPoli = [];

        foreach ($kunjungan as $k) {
            $labels[] = $k->bulan;  // Bulan sebagai label
            $dataPerPoli = [
                'MTBS' => [3, 5, 6, 4, 8, 9], // Data kunjungan per bulan untuk MTBS
                'Poli Umum' => [2, 4, 3, 5, 7, 6], // Data untuk Poli Umum
                'Poli Gigi' => [1, 2, 3, 4, 5, 3], // Data untuk Poli Gigi
            ];  // Data jumlah kunjungan per poli
        }

        // Debug untuk memastikan data
        // dd($dataPerPoli);  // Periksa apakah data terisi dengan benar

        // Buat Line Chart dengan Larapex
        $chart = (new LarapexChart)->lineChart()
            ->setTitle('Kunjungan Pasien Berdasarkan Poli')
            ->setXAxis(array_unique($labels)) // Membuat label bulan unik
            ->setDataset([
                [
                    'name' => 'Poli Umum',
                    'data' => $dataPerPoli['Poli Umum'] ?? []
                ],
                [
                    'name' => 'Poli Gigi',
                    'data' => $dataPerPoli['Poli Gigi'] ?? []
                ],
                // Tambahkan poli lainnya jika ada
            ]);

        return view('petugas.administrator.dashboard', compact('chart'));
    }


}
