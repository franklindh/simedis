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
        Schema::create('pasien', function (Blueprint $table) {
            $table->uuid('id_pasien')->primary();
            $table->string('nik')->unique();
            $table->string('no_rekam_medis')->unique()->nullable();
            $table->string('no_kartu_jaminan')->nullable();
            $table->string('username_pasien')->unique();
            $table->string('no_telepon_pasien')->nullable();
            $table->string('nama_pasien');
            $table->string('alamat_pasien');
            $table->string('tempat_lahir_pasien');
            $table->date('tanggal_lahir_pasien');
            $table->enum('jk_pasien', ['L', 'P']);
            $table->enum('status_pernikahan', ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati']);
            $table->string('nama_keluarga_terdekat')->nullable();
            $table->string('no_telepon_keluarga_terdekat')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('pasien');
    }
};
