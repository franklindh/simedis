<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ICDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('icd')->insert([
            ['kode_icd' => 'A09', 'nama_penyakit' => 'Diare dan gastroenteritis', 'deskripsi_penyakit' => 'Infeksi usus yang menyebabkan diare.'],
            ['kode_icd' => 'J06.9', 'nama_penyakit' => 'Infeksi saluran pernapasan atas akut, tidak spesifik', 'deskripsi_penyakit' => 'ISPA yang melibatkan hidung, sinus, atau tenggorokan.'],
            ['kode_icd' => 'E11', 'nama_penyakit' => 'Diabetes mellitus tipe 2', 'deskripsi_penyakit' => 'Penyakit metabolik yang ditandai oleh hiperglikemia.'],
            ['kode_icd' => 'I10', 'nama_penyakit' => 'Hipertensi esensial (primer)', 'deskripsi_penyakit' => 'Tekanan darah tinggi yang tidak diketahui penyebabnya.'],
            ['kode_icd' => 'J18.9', 'nama_penyakit' => 'Pneumonia, tidak spesifik', 'deskripsi_penyakit' => 'Infeksi paru-paru tanpa penyebab tertentu.'],
            ['kode_icd' => 'B34.9', 'nama_penyakit' => 'Infeksi virus, tidak spesifik', 'deskripsi_penyakit' => 'Infeksi yang disebabkan oleh virus, tanpa lokasi spesifik.'],
            ['kode_icd' => 'M54.5', 'nama_penyakit' => 'Nyeri punggung bawah', 'deskripsi_penyakit' => 'Nyeri yang dirasakan di punggung bawah.'],
            ['kode_icd' => 'I25.9', 'nama_penyakit' => 'Penyakit jantung iskemik kronis, tidak spesifik', 'deskripsi_penyakit' => 'Penyakit jantung akibat aliran darah ke jantung yang terganggu.'],
            ['kode_icd' => 'J45.9', 'nama_penyakit' => 'Asma, tidak spesifik', 'deskripsi_penyakit' => 'Kondisi paru-paru yang menyebabkan kesulitan bernapas.'],
            ['kode_icd' => 'K21.9', 'nama_penyakit' => 'Penyakit refluks gastroesofagus (GERD)', 'deskripsi_penyakit' => 'Aliran balik asam lambung ke esofagus.'],
            ['kode_icd' => 'N39.0', 'nama_penyakit' => 'Infeksi saluran kemih', 'deskripsi_penyakit' => 'Infeksi pada saluran kemih.'],
            ['kode_icd' => 'E66.9', 'nama_penyakit' => 'Obesitas, tidak spesifik', 'deskripsi_penyakit' => 'Berat badan berlebih yang bisa mengganggu kesehatan.'],
            ['kode_icd' => 'F32.9', 'nama_penyakit' => 'Depresi, tidak spesifik', 'deskripsi_penyakit' => 'Gangguan mental yang ditandai oleh perasaan sedih yang terus menerus.'],
            ['kode_icd' => 'L03.90', 'nama_penyakit' => 'Selulitis, tidak spesifik', 'deskripsi_penyakit' => 'Infeksi kulit dan jaringan lunak di bawahnya.'],
            ['kode_icd' => 'J30.9', 'nama_penyakit' => 'Rhinitis alergi, tidak spesifik', 'deskripsi_penyakit' => 'Peradangan hidung akibat alergi.'],
            ['kode_icd' => 'E03.9', 'nama_penyakit' => 'Hipotiroidisme, tidak spesifik', 'deskripsi_penyakit' => 'Kondisi di mana kelenjar tiroid kurang aktif.'],
            ['kode_icd' => 'G47.9', 'nama_penyakit' => 'Gangguan tidur, tidak spesifik', 'deskripsi_penyakit' => 'Kesulitan dalam tidur tanpa penyebab yang jelas.'],
            ['kode_icd' => 'M25.50', 'nama_penyakit' => 'Nyeri sendi, tidak spesifik', 'deskripsi_penyakit' => 'Rasa sakit pada sendi-sendi tubuh.'],
            ['kode_icd' => 'R51', 'nama_penyakit' => 'Sakit kepala', 'deskripsi_penyakit' => 'Sakit pada kepala atau leher.'],
            ['kode_icd' => 'N18.9', 'nama_penyakit' => 'Penyakit ginjal kronis, tidak spesifik', 'deskripsi_penyakit' => 'Kerusakan ginjal yang berlangsung lama.'],
            ['kode_icd' => 'J02.9', 'nama_penyakit' => 'Faringitis akut, tidak spesifik', 'deskripsi_penyakit' => 'Peradangan pada faring, sering disebut radang tenggorokan.'],
            ['kode_icd' => 'I63.9', 'nama_penyakit' => 'Stroke iskemik, tidak spesifik', 'deskripsi_penyakit' => 'Gangguan aliran darah ke otak yang menyebabkan stroke.'],
            ['kode_icd' => 'R10.9', 'nama_penyakit' => 'Nyeri perut, tidak spesifik', 'deskripsi_penyakit' => 'Rasa sakit yang dirasakan di daerah perut.'],
            ['kode_icd' => 'H66.9', 'nama_penyakit' => 'Otitis media, tidak spesifik', 'deskripsi_penyakit' => 'Infeksi atau peradangan pada telinga tengah.'],
            ['kode_icd' => 'J00', 'nama_penyakit' => 'Pilek (nasofaringitis akut)', 'deskripsi_penyakit' => 'Peradangan pada selaput hidung dan tenggorokan yang menyebabkan pilek.'],
            ['kode_icd' => 'K52.9', 'nama_penyakit' => 'Gastroenteritis dan kolitis noninfeksi, tidak spesifik', 'deskripsi_penyakit' => 'Peradangan pada saluran pencernaan tanpa infeksi yang jelas.'],
            ['kode_icd' => 'M79.1', 'nama_penyakit' => 'Mialgia', 'deskripsi_penyakit' => 'Nyeri pada otot tanpa penyebab spesifik.'],
            ['kode_icd' => 'R50.9', 'nama_penyakit' => 'Demam, tidak spesifik', 'deskripsi_penyakit' => 'Peningkatan suhu tubuh tanpa penyebab yang diketahui.'],
            ['kode_icd' => 'J44.9', 'nama_penyakit' => 'Penyakit paru obstruktif kronik, tidak spesifik', 'deskripsi_penyakit' => 'Penyakit paru-paru kronis yang menyulitkan bernapas.'],
            ['kode_icd' => 'B37.0', 'nama_penyakit' => 'Kandidiasis mulut', 'deskripsi_penyakit' => 'Infeksi jamur pada mulut.'],
            ['kode_icd' => 'N40.0', 'nama_penyakit' => 'Hiperplasia prostat jinak', 'deskripsi_penyakit' => 'Pembesaran kelenjar prostat yang jinak.'],
            ['kode_icd' => 'K59.1', 'nama_penyakit' => 'Sembelit', 'deskripsi_penyakit' => 'Kesulitan buang air besar.'],
            ['kode_icd' => 'L29.9', 'nama_penyakit' => 'Pruritus, tidak spesifik', 'deskripsi_penyakit' => 'Gatal tanpa penyebab yang jelas.'],
            ['kode_icd' => 'E78.5', 'nama_penyakit' => 'Hiperlipidemia, tidak spesifik', 'deskripsi_penyakit' => 'Kadar lipid tinggi dalam darah.'],
            ['kode_icd' => 'I20.9', 'nama_penyakit' => 'Angina pektoris, tidak spesifik', 'deskripsi_penyakit' => 'Nyeri dada akibat berkurangnya aliran darah ke jantung.'],
            ['kode_icd' => 'K30', 'nama_penyakit' => 'Dispepsia', 'deskripsi_penyakit' => 'Ketidaknyamanan atau sakit perut bagian atas.'],
            ['kode_icd' => 'J20.9', 'nama_penyakit' => 'Bronkitis akut, tidak spesifik', 'deskripsi_penyakit' => 'Peradangan akut pada bronkus.'],
            ['kode_icd' => 'R19.7', 'nama_penyakit' => 'Diare fungsional', 'deskripsi_penyakit' => 'Diare tanpa penyebab organik yang jelas.'],
            ['kode_icd' => 'K04.7', 'nama_penyakit' => 'Radang pulpa gigi', 'deskripsi_penyakit' => 'Peradangan pada pulpa gigi yang menyebabkan rasa sakit.'],
            // Tambahkan sisa data ICD-10 di sini, hingga total 50
        ]);
    }
}
