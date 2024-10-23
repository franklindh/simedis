<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

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
}
