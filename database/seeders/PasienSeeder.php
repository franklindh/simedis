<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pasien;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Str;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pasien::create([
        //     'nik' => '1234567890123456',
        //     'no_rm' => 1234,
        //     'username_pasien' => 'pasien',
        //     'no_telepon_pasien' => '081234567890',
        //     'nama_pasien' => 'Udin',
        //     'alamat_pasien' => 'Jl. Pasien',
        //     'tempat_lahir_pasien' => 'Pasien',
        //     'tanggal_lahir_pasien' => '2000-01-01',
        //     'jenis_kelamin_pasien' => 'P',
        //     'password' => bcrypt('password'),
        // ]);
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            Pasien::create([
                'id_pasien' => Str::uuid(),
                'nik' => $this->generateBigInt(16),
                'no_rekam_medis' => $faker->numberBetween(100000, 999999),
                'no_kartu_jaminan' => $faker->numberBetween(1000, 9999),
                'username_pasien' => $faker->userName,
                'no_telepon_pasien' => $faker->phoneNumber,
                'nama_pasien' => $faker->name,
                'alamat_pasien' => $faker->address,
                'tempat_lahir_pasien' => $faker->city,
                'tanggal_lahir_pasien' => $faker->date('Y-m-d', '2010-12-31'),
                'jk_pasien' => $faker->randomElement(['P', 'L']),
                'password' => Hash::make('password'),
            ]);
        }
    }
    private function generateBigInt($length)
    {
        $number = '';
        for ($i = 0; $i < $length; $i++) {
            $number .= mt_rand(0, 9);
        }
        return (int) $number;
    }
}
