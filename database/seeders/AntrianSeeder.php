<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Antrian;
use Illuminate\Support\Str;

class AntrianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Daftar kode poli
        $kodePolis = [
            'Anak' => 'A',
            'Umum' => 'U',
            'Lansia' => 'L',
            'KIA' => 'K',
            'Kusta' => 'KU',
            'Gigi' => 'G',
        ];

        // Ambil jadwal beserta nama poli dengan join
        $jadwals = DB::table('jadwal')
            ->join('poli', 'jadwal.id_poli', '=', 'poli.id_poli')
            ->select('jadwal.id_jadwal', 'poli.nama_poli', 'poli.id_poli')
            ->get();

        foreach ($jadwals as $jadwal) {
            $kodePoli = $kodePolis[$jadwal->nama_poli] ?? 'X';

            $jumlahAntrian = DB::table('antrian')
                ->where('id_jadwal', $jadwal->id_jadwal)
                ->count();

            $jumlahAntrianBaru = rand(5, 10);

            for ($i = 1; $i <= $jumlahAntrianBaru; $i++) {
                $nomorUrut = $jumlahAntrian + $i;
                $nomorAntrian = $kodePoli . sprintf('%03d', $nomorUrut);

                // Tambahkan waktu yang berbeda untuk setiap entri
                $createdAt = now()->addSeconds($i); // Tambahkan beberapa detik untuk setiap entri

                DB::table('antrian')->insert([
                    'nomor_antrian' => $nomorAntrian,
                    'id_jadwal' => $jadwal->id_jadwal,
                    'id_pasien' => $faker->randomElement(DB::table('pasien')->pluck('id_pasien')->toArray()),
                    'prioritas' => 'Non Gawat',
                    // 'status' => 'Selesai',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }

    }

}
