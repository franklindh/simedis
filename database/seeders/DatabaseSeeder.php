<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                // PasienSeeder::class,
                // PoliSeeder::class,
                // PetugasSeeder::class,
                // ICDSeeder::class,
                // JadwalSeeder::class,
                // AntrianSeeder::class,
                // PemeriksaanSeeder::class,
            JenisPemeriksaanLab::class,
        ]);
    }
}
