<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanLab extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_lab';
    protected $fillable = [
        'id_pemeriksaan',             // Foreign key ke tabel pemeriksaan utama
        'nama_pemeriksaan',           // Nama jenis pemeriksaan (misalnya, Glukosa Sewaktu)
        'jenis_pemeriksaan',          // Jenis pemeriksaan (misalnya, gula darah)
        'hasil',                      // Hasil pemeriksaan (diisi setelah tes)
        'kode_lab',                   // Kode laboratorium (misalnya, LAB-xxxx)
        'dokumen_hasil_pemeriksaan_lab' // Dokumen pendukung hasil pemeriksaan
    ];
}
