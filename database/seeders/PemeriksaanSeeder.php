<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        // Ambil semua id_antrian dari bulan November 2024
        $antrianNovember = DB::table('antrian')
            ->whereMonth('created_at', 11)
            ->whereYear('created_at', 2024)
            ->pluck('id_antrian');

        // Ambil semua id_icd dari tabel ICD
        $icdIds = DB::table('icd')->pluck('id_icd');

        // Data dummy untuk pemeriksaan
        $dummyData = [
            [
                'nadi' => '80',
                'tekanan_darah' => '120/80',
                'suhu' => '36.5',
                'berat_badan' => '60',
                'keadaan_umum' => 'Baik',
                'keluhan' => 'Demam selama 3 hari',
                'riwayat_penyakit' => 'Tidak ada',
                'keterangan' => 'Pasien stabil',
                'tindakan' => 'Diberikan obat demam',
            ],
            [
                'nadi' => '85',
                'tekanan_darah' => '130/85',
                'suhu' => '37.2',
                'berat_badan' => '70',
                'keadaan_umum' => 'Lemah',
                'keluhan' => 'Batuk dan pilek',
                'riwayat_penyakit' => 'Alergi debu',
                'keterangan' => 'Gejala alergi',
                'tindakan' => 'Obat antihistamin',
            ],
            [
                'nadi' => '75',
                'tekanan_darah' => '110/70',
                'suhu' => '36.8',
                'berat_badan' => '65',
                'keadaan_umum' => 'Sesak',
                'keluhan' => 'Nyeri dada',
                'riwayat_penyakit' => 'Asma',
                'keterangan' => 'Pasien memerlukan pemeriksaan lanjutan',
                'tindakan' => 'Rujukan ke spesialis',
            ],
        ];

        // Looping untuk setiap antrian di bulan November
        foreach ($antrianNovember as $antrianId) {
            $randomData = $dummyData[array_rand($dummyData)]; // Pilih data dummy secara acak
            $randomIcd = $icdIds->random(); // Pilih id_icd secara acak
            $randomDate = Carbon::create(2024, 11, rand(1, 30), rand(8, 16), rand(0, 59), 0);

            DB::table('pemeriksaan')->insert([
                'id_antrian' => $antrianId,
                'id_icd' => $randomIcd,
                'nadi' => $randomData['nadi'],
                'tekanan_darah' => $randomData['tekanan_darah'],
                'suhu' => $randomData['suhu'],
                'berat_badan' => $randomData['berat_badan'],
                'keadaan_umum' => $randomData['keadaan_umum'],
                'keluhan' => $randomData['keluhan'],
                'riwayat_penyakit' => $randomData['riwayat_penyakit'],
                'keterangan' => $randomData['keterangan'],
                'tindakan' => $randomData['tindakan'],
                'tanggal_pemeriksaan' => $randomDate->toDateString(), // Masukkan tanggal pemeriksaan
                'created_at' => $randomDate,
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
