<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_pemeriksaan_lab', function (Blueprint $table) {
            $table->id('id_jenis_pemeriksaan');
            $table->string('nama_pemeriksaan'); // Nama indikator pemeriksaan
            $table->string('satuan')->nullable(); // Satuan indikator (mg/dL, %, dsb.)
            $table->string('nilai_rujukan')->nullable(); // Nilai rujukan
            $table->string('kriteria')->nullable(); // Kriteria khusus (umur, jenis kelamin, dll.)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jenis_pemeriksaan_lab');
    }
};
