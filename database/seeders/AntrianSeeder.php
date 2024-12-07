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
        // Tentukan rentang tanggal 3 bulan kebelakang
        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();
        $polis = [
            1 => 'G', // Gigi
            2 => 'A', // Anak
            3 => 'U', // Umum
            4 => 'K', // KIA
            5 => 'L'  // Lansia
        ]; // Inisial berdasarkan poli
        $pasienIds = DB::table('pasien')
            ->pluck('id_pasien'); // Contoh ID Pasien
        $statuses = ['Menunggu'];
        $priorities = ['Gawat', 'Non Gawat'];

        $jadwals = DB::table('jadwal')
            ->whereMonth('tanggal_praktik', 11)
            ->whereYear('tanggal_praktik', 2024)
            ->get();


        foreach ($jadwals as $jadwal) {
            foreach ($pasienIds as $pasienId) {
                // Generate data antrian
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
