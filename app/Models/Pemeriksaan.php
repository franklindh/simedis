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
        'id_pemeriksaan',
        'id_antrian',
        'id_icd',
        'nadi',
        'riwayat_penyakit',
        'tekanan_darah',
        'berat_badan',
        'keadaan_umum',
        'suhu',
        'keluhan',
        'keterangan',
        'tindakan',
        'tanggal_pemeriksaan',
    ];

    public function icd()
    {
        return $this->belongsTo(Icd::class, 'id_icd', 'id_icd');
    }
}
