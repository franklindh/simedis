<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('poli')->insert([
            ['nama_poli' => 'Gigi'],
            ['nama_poli' => 'Anak'],
            ['nama_poli' => 'Umum'],
            ['nama_poli' => 'KIA'],
            ['nama_poli' => 'Lansia'],
        ]);
    }
}
