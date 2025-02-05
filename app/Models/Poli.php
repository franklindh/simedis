<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poli extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'poli';

    protected $primaryKey = 'id_poli';

    protected $fillable = [
        'id_poli',
        'nama_poli',
        'status_poli'
    ];

}
