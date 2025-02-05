<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ICD extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'icd';

    protected $primaryKey = 'id_icd';

    protected $fillable = [
        'kode_icd',
        'nama_penyakit',
        'deskripsi_penyakit',
        'status_icd'
    ];
}
