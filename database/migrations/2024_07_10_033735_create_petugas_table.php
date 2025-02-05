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
        Schema::create('petugas', function (Blueprint $table) {
            $table->id('id_petugas');
            $table->unsignedBigInteger('id_poli')->nullable();
            $table->string('username_petugas')->unique();
            $table->string('nama_petugas');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->enum('role', ['Administrasi', 'Poliklinik', 'Dokter', 'Lab']);
            $table->string('password');

            $table->softDeletes();

            $table->foreign('id_poli')->references('id_poli')->on('poli')->onDelete('cascade');

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
        Schema::dropIfExists('petugas');
    }
};
