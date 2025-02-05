<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        // Tentukan rentang tanggal untuk bulan Desember 2024
        $startDate = Carbon::create(2024, 11, 1);
        $endDate = Carbon::create(2024, 11, 31);

        $polis = [
            1 => 'G', // Gigi
            2 => 'A', // Anak
            3 => 'U', // Umum
            4 => 'K', // KIA
            5 => 'L'  // Lansia
        ]; // Inisial berdasarkan poli
        $pasienIds = DB::table('pasien')
            ->pluck('id_pasien'); // Ambil ID Pasien
        $statuses = ['Menunggu'];
        $priorities = ['Gawat', 'Non Gawat'];

        // Ambil jadwal dengan tanggal acak
        $jadwals = DB::table('jadwal')
            ->whereBetween('tanggal_praktik', [$startDate->toDateString(), $endDate->toDateString()])
            ->get();

        foreach ($jadwals as $jadwal) {
            // Ambil jumlah antrian acak untuk setiap jadwal
            $jumlahAntrian = rand(1, 5); // Maksimal 5 pasien per jadwal
            $pasienAntrian = $pasienIds->random($jumlahAntrian); // Ambil pasien acak

            foreach ($pasienAntrian as $pasienId) {
                // Insert data ke tabel antrian
                DB::table('antrian')->insert([
                    'id_jadwal' => $jadwal->id_jadwal,
                    'id_pasien' => $pasienId,
                    'nomor_antrian' => $polis[$jadwal->id_poli] . rand(100, 999), // Nomor antrian dengan inisial poli
                    'prioritas' => $priorities[array_rand($priorities)],
                    'status' => $statuses[array_rand($statuses)],
                    'created_at' => Carbon::parse($jadwal->tanggal_praktik)->setTime(rand(8, 15), rand(0, 59))->toDateTimeString(),
                    'updated_at' => now(),
                ]);
            }
        }
    }


}
