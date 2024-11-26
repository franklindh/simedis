<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'id_pasien',
        'nik',
        'no_rekam_medis',
        'username_pasien',
        'no_telepon_pasien',
        'nama_pasien',
        'alamat_pasien',
        'tempat_lahir_pasien',
        'tanggal_lahir_pasien',
        'jk_pasien',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Fungsi untuk menghasilkan nomor rekam medis
    // public static function generateNoRM()
    // {
    //     // Ambil tahun saat ini
    //     $year = Carbon::now()->format('Y');

    //     // Ambil pasien terakhir yang didaftarkan pada tahun ini
    //     // $lastPasien = self::whereYear('created_at', $year)
    //     //     ->orderBy('no_rekam_medis', 'desc')
    //     //     ->first();
    //     $lastPasien = self::whereYear('created_at', $year)
    //         ->orderBy('no_rekam_medis', 'desc')
    //         ->lockForUpdate()
    //         ->first();


    //     // Jika tidak ada pasien pada tahun ini, mulai dari 0001
    //     if (!$lastPasien) {
    //         $newNumber = '0001';
    //     } else {
    //         // Ambil bagian terakhir dari no_rm dan tambahkan 1
    //         $lastNumber = substr($lastPasien->no_rm, -4);
    //         $newNumber = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
    //     }

    //     // Gabungkan menjadi nomor rekam medis lengkap
    //     return 'RM-' . $year . '-' . $newNumber;
    // }
    public static function generateNoRM()
    {
        // Ambil tahun saat ini
        $year = Carbon::now()->format('Y');

        // Gunakan lock untuk mencegah race condition
        $lastPasien = self::whereYear('created_at', $year)
            ->orderBy('no_rekam_medis', 'desc')
            ->lockForUpdate()
            ->first();

        // Jika tidak ada pasien pada tahun ini, mulai dari 0001
        if (!$lastPasien) {
            $newNumber = '0001';
        } else {
            // Ambil bagian terakhir dari no_rm dan tambahkan 1
            $lastNumber = substr($lastPasien->no_rekam_medis, -4);
            $newNumber = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        // Gabungkan menjadi nomor rekam medis lengkap
        return "RM-$year-$newNumber";
    }

}
