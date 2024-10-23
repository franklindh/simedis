<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ICD extends Model
{
    use HasFactory;

    protected $table = 'icd';

    protected $primaryKey = 'id_icd';
}
