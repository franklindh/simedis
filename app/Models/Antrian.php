<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Antrian extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'antrian';

    protected $primaryKey = 'id_antrian';

    protected $fillable = [
        'id_antrian',
        'id_pasien',
        'id_jadwal',
        'nomor_antrian',
        'status',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }
}
