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
        Schema::create('pemeriksaan_lab', function (Blueprint $table) {
            $table->id('id_pemeriksaan_lab');
            $table->unsignedBigInteger('id_pemeriksaan');
            $table->string('nama_pemeriksaan')->nullable();
            $table->string('satuan')->nullable();
            $table->string('jenis_pemeriksaan')->nullable();
            $table->string('nilai_rujukan')->nullable();
            $table->string('hasil')->nullable();
            $table->string('kode_lab', 255)->nullable();
            $table->string('dokumen_hasil_pemeriksaan_lab')->nullable();

            $table->foreign('id_pemeriksaan')->references('id_pemeriksaan')->on('pemeriksaan')->onDelete('cascade');

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
        Schema::dropIfExists('pemeriksaan_lab');
    }
};
