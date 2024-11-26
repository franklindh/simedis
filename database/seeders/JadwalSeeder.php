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
        $faker = Faker::create('id_ID');

        // Ambil data dokter dan poli dari database
        $dokter = DB::table('petugas')
            ->where('role', 'Dokter')
            ->pluck('id_petugas');

        $poli = DB::table('poli')
            ->pluck('id_poli');

        // Tanggal awal dan akhir untuk jadwal
        $startDate = Carbon::create(2024, 11, 25); // 23 November 2024
        $endDate = Carbon::create(2024, 11, 30);   // 30 November 2024

        while ($startDate->lte($endDate)) {
            foreach ($dokter as $dokterId) {
                Jadwal::create([
                    'tanggal_praktik' => $startDate->format('Y-m-d'),
                    'waktu_mulai' => '07:00:00',
                    'waktu_selesai' => '12:00:00',
                    'keterangan' => 'Jadwal praktek pagi',
                    'id_petugas' => $dokterId,
                    'id_poli' => $poli->random(), // Pilih poli secara acak
                ]);
            }
            $startDate->addDay(); // Tambahkan 1 hari
        }
    }
}
