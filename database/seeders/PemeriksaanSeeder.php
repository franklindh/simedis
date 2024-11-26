<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pasien;
use App\Models\Petugas;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

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

        // Ambil semua ID antrian dari tabel `antrian`
        $antrianIds = DB::table('antrian')->pluck('id_antrian');

        // Ambil data ICD dari tabel `icd`
        $icdIds = DB::table('icd')->pluck('id_icd');

        foreach ($antrianIds as $antrianId) {
            // Buat data pemeriksaan untuk setiap antrian
            DB::table('pemeriksaan')->insert([
                'id_antrian' => $antrianId,
                'id_icd' => $faker->randomElement($icdIds),
                'nadi' => $faker->numberBetween(60, 100),
                'tekanan_darah' => $faker->numberBetween(90, 140),
                'suhu' => $faker->randomFloat(1, 36.0, 39.0),
                'berat_badan' => $faker->randomFloat(1, 50, 100),
                'keadaan_umum' => $faker->randomElement(['Baik', 'Sedang', 'Lemah']),
                'keluhan' => $faker->sentence(5),
                'riwayat_penyakit' => $faker->sentence(8),
                'keterangan' => $faker->sentence(6),
                'tindakan' => $faker->sentence(5),
                'tanggal_pemeriksaan' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
