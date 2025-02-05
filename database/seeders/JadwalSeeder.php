<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Jadwal;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tentukan rentang bulan Desember 2024
        $startDate = Carbon::create(2024, 11, 1); // Awal Desember 2024
        $endDate = Carbon::create(2024, 11, 31); // Akhir Desember 2024
        $poli = DB::table('poli')->pluck('id_poli');
        $dokter = DB::table('petugas')
            ->where('role', 'Dokter')
            ->pluck('id_petugas');
        $waktuMulai = '08:00:00';
        $waktuSelesai = '16:00:00';

        foreach ($poli as $poliId) {
            foreach ($dokter as $petugasId) {
                // Generate tanggal acak pada bulan Desember
                $randomDate = Carbon::createFromTimestamp(mt_rand($startDate->timestamp, $endDate->timestamp));

                // Insert jadwal untuk kombinasi poli dan petugas dengan tanggal acak
                DB::table('jadwal')->insert([
                    'id_petugas' => $petugasId,
                    'id_poli' => $poliId,
                    'tanggal_praktik' => $randomDate->toDateString(),
                    'waktu_mulai' => $waktuMulai,
                    'waktu_selesai' => $waktuSelesai,
                    'keterangan' => 'Jadwal praktik',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
