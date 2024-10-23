<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Petugas;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Petugas>
 */
class PetugasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Petugas::class;
    public function definition()
    {
        return [
            'username_petugas' => $this->faker->userName,
            'nama_petugas' => $this->faker->name,
            'nomor_telepon_petugas' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['aktif', 'nonaktif']),
            'role' => $this->faker->randomElement(['Administrasi', 'Dokter', 'Poliklinik']),
            'password' => Hash::make('password'), // Menggunakan hash bcrypt
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
