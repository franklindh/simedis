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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->unsignedBigInteger('id_petugas');
            $table->unsignedBigInteger('id_poli');
            $table->date('tanggal_praktik');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('keterangan')->nullable();

            $table->softDeletes();

            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade');
            $table->foreign('id_poli')->references('id_poli')->on('poli')->onDelete('cascade');

            $table->timestamps();

            // $table->foreign('id_petugas')->references('id')->on('petugas');
            // $table->foreign('id_petugas')->references('id')->on('petugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
};
