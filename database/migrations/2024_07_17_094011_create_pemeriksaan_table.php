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
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id('id_pemeriksaan');
            $table->unsignedBigInteger('id_antrian');
            $table->unsignedBigInteger('id_icd');
            $table->string('nadi')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->string('suhu')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('keadaan_umum')->nullable();
            $table->string('keluhan')->nullable();
            $table->string('riwayat_penyakit')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('tindakan')->nullable();
            $table->date('tanggal_pemeriksaan');

            $table->foreign('id_antrian')->references('id_antrian')->on('antrian')->onDelete('cascade');
            $table->foreign('id_icd')->references('id_icd')->on('icd')->onDelete('cascade');

            $table->timestamps();

            // $table->foreignId('nik_pasien')->constrained('pasien');
            // $table->foreignId('id_petugas')->constrained('petugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
