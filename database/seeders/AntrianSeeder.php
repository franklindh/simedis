<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Antrian;

class AntrianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Mengambil ID pasien
        $pasienId = DB::table('pasien')
            ->pluck('id_pasien')->toArray();

        // Mengambil ID jadwal
        $jadwalId = DB::table('jadwal')
            ->pluck('id_jadwal')->toArray();

        // Mengambil ID poli terkait jadwal
        $poliData = DB::table('jadwal')
            ->join('poli', 'jadwal.id_poli', 'poli.id_poli')
            ->select('jadwal.id_jadwal', 'poli.id_poli', 'poli.nama_poli')
            ->get();

        // Loop untuk membuat data antrian
        for ($i = 0; $i < count($jadwalId); $i++) {
            // Dapatkan data poli untuk jadwal yang sedang diiterasi
            $poli = $poliData->where('id_jadwal', $jadwalId[$i])->first();

            // Tentukan kode poli berdasarkan nama poli
            switch ($poli->nama_poli) {
                case 'MTBS':
                    $kodePoli = 'M';
                    break;
                case 'Anak':
                    $kodePoli = 'A';
                    break;
                case 'Umum':
                    $kodePoli = 'U';
                    break;
                case 'Lansia':
                    $kodePoli = 'L';
                    break;
                case 'KIA-KB':
                    $kodePoli = 'K';
                    break;
                case 'Imunisasi':
                    $kodePoli = 'I';
                    break;
                case 'Laboratorium':
                    $kodePoli = 'B';
                    break;
                case 'Konseling Gizi':
                    $kodePoli = 'KG';
                    break;
                case 'Konseling Sanitasi':
                    $kodePoli = 'KS';
                    break;
                default:
                    $kodePoli = 'L';
                    break;
            }

            // Membuat nomor antrian unik berdasarkan poli dan urutan
            $nomorAntrian = $kodePoli . str_pad($i + 1, 3, '0', STR_PAD_LEFT);

            // Insert ke tabel antrian
            Antrian::create([
                'nomor_antrian' => $nomorAntrian,
                // 'status' => $faker->randomElement(['Menunggu', 'Menunggu Diagnosis', 'Selesai']),
                'status' => 'Menunggu',
                'prioritas' => $faker->randomElement(['Gawat', 'Non Gawat']),
                'id_pasien' => $pasienId[$i],
                'id_jadwal' => $jadwalId[$i],
            ]);
        }
    }
}
