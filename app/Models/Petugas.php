<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Petugas extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    use SoftDeletes;

    protected $table = 'petugas';

    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'id_petugas',
        'username_petugas',
        'nama_petugas',
        'status',
        'role',
        'id_poli',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

}
