<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $table = 'petugas';

    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'id_petugas',
        'username_petugas',
        'nama_petugas',
        'status',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

}
