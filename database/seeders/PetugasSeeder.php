<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            DB::table('petugas')->insert([
                'username_petugas' => $faker->userName,
                'nama_petugas' => $faker->name,
                'no_telepon_petugas' => $faker->phoneNumber,
                'status' => $faker->randomElement(['aktif', 'nonaktif']),
                'role' => $faker->randomElement(['Dokter', 'Poliklinik', 'Administrasi']),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // Petugas::factory()->count(50)->create();
    }
}
