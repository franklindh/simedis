<?php

namespace Database\Seeders;

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

        $dokter = DB::table('petugas')
            ->where('role', 'Dokter')
            ->pluck('id_petugas');

        $poli = DB::table('poli')
            ->pluck('id_poli');

        for ($i = 0; $i < 3; $i++) {
            Jadwal::create([
                'tanggal_praktik' => now(),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '12:00:00',
                'keterangan' => 'Jadwal praktek pagi',
                'id_petugas' => $dokter[$i],
                'id_poli' => $poli[0],
            ]);
        }
    }
}
