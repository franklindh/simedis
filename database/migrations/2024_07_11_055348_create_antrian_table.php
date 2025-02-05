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
        Schema::create('antrian', function (Blueprint $table) {
            $table->id('id_antrian');
            $table->unsignedBigInteger('id_jadwal');
            $table->uuid('id_pasien');
            $table->string('nomor_antrian');
            $table->enum('prioritas', ['Gawat', 'Non Gawat'])->default('Non Gawat');
            $table->enum('status', ['Menunggu', 'Menunggu Diagnosis', 'Selesai'])->default('Menunggu');

            $table->softDeletes();

            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal')->onDelete('cascade');
            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->onDelete('cascade');


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
        Schema::dropIfExists('antrian');
    }
};
