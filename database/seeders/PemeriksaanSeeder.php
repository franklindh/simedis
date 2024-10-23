<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pasien;
use App\Models\Petugas;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PemeriksaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $antrian = DB::table('antrian')->pluck('id_antrian');

        $icd = DB::table('icd')->pluck('id_icd');

        for ($i = 0; $i < 3; $i++) {
            DB::table('pemeriksaan')->insert([
                'nadi' => $faker->numberBetween(60, 100), // Denyut nadi biasanya antara 60-100 bpm
                'tekanan_darah' => $faker->numberBetween(90, 140) . '/' . $faker->numberBetween(60, 90), // Format tekanan darah
                'suhu' => $faker->randomFloat(1, 36, 37), // Suhu badan dalam derajat celcius
                'berat_badan' => $faker->numberBetween(40, 100) . ' kg', // Berat badan dalam kg
                'keadaan_umum' => $faker->randomElement(['Baik', 'Cukup', 'Lemah']),
                'keluhan' => $faker->sentence,
                'keterangan' => $faker->text,
                'tindakan' => $faker->sentence,
                'tanggal_pemeriksaan' => $faker->date('Y-m-d'),
                'id_antrian' => $antrian[$i],
                'id_icd' => $antrian[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
