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
        Schema::create('icd', function (Blueprint $table) {
            $table->id('id_icd');
            $table->string('kode_icd')->unique();
            $table->string('nama_penyakit');
            $table->string('deskripsi_penyakit')->nullable();
            $table->string('status_icd')->default('aktif');
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
        Schema::dropIfExists('icd');
    }
};
