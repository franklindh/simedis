<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiRujukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nilai_rujukan')->insert([
            // Hematologi
            [
                'nama_pemeriksaan' => 'Haemoglobin',
                'satuan' => 'gr%',
                'nilai_rujukan' => 'L: 14-18, P: 12-16',
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
            [
                'nama_pemeriksaan' => 'Eritrosit',
                'satuan' => 'juta sel/mm3',
                'nilai_rujukan' => 'L: 4.5-5.5, P: 4.0-5.0',
                'kriteria' => 'Hematologi',
            ],
            [
                'nama_pemeriksaan' => 'Hematokrit',
                'satuan' => '%',
                'nilai_rujukan' => 'L: 40-48, P: 37-43',
                'kriteria' => 'Hematologi',
            ],
            [
                'nama_pemeriksaan' => 'LED',
                'satuan' => 'mm/jam',
                'nilai_rujukan' => 'L: 0-10, P: 0-20',
                'kriteria' => 'Hematologi',
            ],

            // Kimia Klinik
            [
                'nama_pemeriksaan' => 'Gula Darah Sewaktu',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '70-140',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Gula Darah Puasa',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '70-110',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Gula Darah 2 Jam PP',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '70-110',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Asam Urat',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => 'L: 3.6-7.7, P: 2.5-6.8',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Ureum',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '8-40',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Kreatinin',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => 'L: 0.6-1.3, P: 0.5-0.9',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'SGOT',
                'satuan' => 'IU/L',
                'nilai_rujukan' => 'L: <35, P: <31',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'SGPT',
                'satuan' => 'IU/L',
                'nilai_rujukan' => 'L: <35, P: <31',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Kolesterol Total',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '<200',
                'kriteria' => 'Kimia Klinik',
            ],
            [
                'nama_pemeriksaan' => 'Trigliserida',
                'satuan' => 'mg/dl',
                'nilai_rujukan' => '<150',
                'kriteria' => 'Kimia Klinik',
            ],

            // Urine
            [
                'nama_pemeriksaan' => 'Warna',
                'satuan' => '-',
                'nilai_rujukan' => 'Kuning',
                'kriteria' => 'Urine',
            ],
            [
                'nama_pemeriksaan' => 'Kejernihan',
                'satuan' => '-',
                'nilai_rujukan' => 'Jernih',
                'kriteria' => 'Urine',
            ],
            [
                'nama_pemeriksaan' => 'pH',
                'satuan' => '-',
                'nilai_rujukan' => '4.7-7.5',
                'kriteria' => 'Urine',
            ],
            [
                'nama_pemeriksaan' => 'Berat Jenis',
                'satuan' => '-',
                'nilai_rujukan' => '1.002-1.030',
                'kriteria' => 'Urine',
            ],
        ]);
    }
}
