<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPemeriksaanLab extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_pemeriksaan_lab')->insert([
            // Hematologi
            [
                'nama_pemeriksaan' => 'Hemoglobin',
                'satuan' => 'gr/dl',
                'nilai_rujukan' => 'L: 12-14, P: 14-16, Ibu Hamil: 10-11',
                'kriteria' => 'Hematologi',
            ],
            [
                'nama_pemeriksaan' => 'Leukosit',
                'satuan' => '10^3/mm3',
                'nilai_rujukan' => '4.000-10.000',
                'kriteria' => 'Hematologi',
            ],
            [
                'nama_pemeriksaan' => 'Trombosit',
                'satuan' => '10^3/mm3',
                'nilai_rujukan' => '150.000-450.000',
                'kriteria' => 'Hematologi',
            ],
            // Kimia Klinik
            [
                'nama_pemeriksaan' => 'Glukosa Sewaktu',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '70/140',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Glukosa Puasa',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '70/110',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Glukosa 2 Jam PP',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '70/110',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Asam Urat',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => 'L: <3.6-7.7, P: <2.5-6.8',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Kolestrol',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '< 200',
                'kriteria' => 'Kimia Klinik',
            ],
            // Urine
            [
                'nama_pemeriksaan' => 'Warna',
                'satuan' => '',
                'nilai_rujukan' => 'Kuning',
                'kriteria' => 'Urine',
            ],
            [
                'nama_pemeriksaan' => 'pH',
                'satuan' => '',
                'nilai_rujukan' => '4.7-7.5',
                'kriteria' => 'Urine',
            ],
            [
                'nama_pemeriksaan' => 'Protein',
                'satuan' => '',
                'nilai_rujukan' => 'Negatif',
                'kriteria' => 'Urine',
            ],
            [
                'nama_pemeriksaan' => 'Glukosa',
                'satuan' => '',
                'nilai_rujukan' => 'Negatif',
                'kriteria' => 'Urine',
            ],
        ]);
    }
}
