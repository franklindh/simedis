<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'jadwal';

    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_jadwal',
        'tanggal_praktik',
        'waktu_mulai',
        'waktu_selesai',
        'keterangan',
        'id_petugas',
        'id_poli',
    ];

    // Relasi ke tabel Poli
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'id_poli');
    }

    // Relasi ke tabel Petugas
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}
