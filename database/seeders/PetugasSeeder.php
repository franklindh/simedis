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

        $poli = DB::table('poli')
            ->pluck('id_poli');

        $data = [
            [
                'username_petugas' => 'admin',
                'nama_petugas' => 'Udin',
                'role' => 'Administrasi',
                'status' => 'aktif',
                'password' => Hash::make('password'), // Enkripsi password
            ],
            [
                'username_petugas' => 'poli',
                'nama_petugas' => 'Jamal',
                'role' => 'Poliklinik',
                'status' => 'aktif',
                'password' => Hash::make('password'),
                'id_poli' => $poli->random()
            ],
            [
                'username_petugas' => 'dokter',
                'nama_petugas' => 'Tirta',
                'role' => 'Dokter',
                'status' => 'aktif',
                'password' => Hash::make('password'),
            ],
            [
                'username_petugas' => 'lab',
                'nama_petugas' => 'Asep',
                'role' => 'Lab',
                'status' => 'aktif',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($data as $petugas) {
            Petugas::create($petugas);
        }


        // for ($i = 0; $i < 10; $i++) {
        //     DB::table('petugas')->insert([
        //         'username_petugas' => $faker->userName,
        //         'nama_petugas' => $faker->name,
        //         'no_telepon_petugas' => $faker->phoneNumber,
        //         'status' => $faker->randomElement(['aktif', 'nonaktif']),
        //         'role' => $faker->randomElement(['Dokter', 'Poliklinik', 'Administrasi']),
        //         'password' => Hash::make('password'),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
        // Petugas::factory()->count(50)->create();

        //     DB::table('petugas')->insert([
        //         'username_petugas' => $faker->userName,
        //         'nama_petugas' => $faker->name,
        //         'no_telepon_petugas' => $faker->phoneNumber,
        //         'status' => $faker->randomElement(['aktif', 'nonaktif']),
        //         'role' => $faker->randomElement(['Dokter', 'Poliklinik', 'Administrasi']),
        //         'password' => Hash::make('password'),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
    }
}
