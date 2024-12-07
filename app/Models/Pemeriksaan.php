<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan';

    protected $primaryKey = 'id_pemeriksaan';

    protected $fillable = [
        'id_antrian',
        'id_icd',
        'nadi',
        'tekanan_darah',
        'suhu',
        'berat_badan',
        'keadaan_umum',
        'keluhan',
        'riwayat_penyakit',
        'keterangan',
        'tindakan',
        'tanggal_pemeriksaan',
        // 'kode_lab',
        // 'jenis_pemeriksaan_lab',
        // 'sub_pemeriksaan_lab',
        // 'hasil_pemeriksaan_lab',
        // 'dokumen_hasil_pemeriksaan_lab',
        // 'status_pemeriksaan_lab',
    ];

    public function icd()
    {
        return $this->belongsTo(Icd::class, 'id_icd', 'id_icd');
    }
}
