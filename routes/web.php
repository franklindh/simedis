<?php



use App\Http\Controllers\Administrasi\DashboardController;
use App\Http\Controllers\Administrasi\PenggunaController;
use App\Http\Controllers\Administrasi\RekamController;
use App\Http\Controllers\Administrasi\PendaftaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Poliklinik\PemeriksaanController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('logins.authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::group(['middleware' => ['auth:petugas']], function () {
//     Route::prefix('administrasi')->group(function () {
//         Route::get('/rekam', [RekamController::class, 'index'])->name('rekam');
//         Route::get('/rekam/detail/{nik}', [RekamController::class, 'detailById'])->name('detailById');
//         Route::get('/rekam/detail/{nik}/{tanggal}', [RekamController::class, 'detailByTanggal'])->name('detailByTanggal');
//         Route::get('/cari', [RekamController::class, 'cari'])->name('cari');
//         Route::get('/cetak', [RekamController::class, 'cetak'])->name('cetak');


//         Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran');


//         Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
//         Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
//         Route::get('/pengguna/reset-password/{id}', [PenggunaController::class, 'resetPassword'])->name('pengguna.reset-password');

//     });
// });

Route::group(['middleware' => ['petugas:Administrasi']], function () {
    Route::prefix('administrasi')->group(function () {
        Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran');
        Route::post('/pendaftaran/pasien', [PendaftaranController::class, 'storePasien'])->name('pendaftaran.pasien.store');
        Route::post('/pendaftaran/antrian', [PendaftaranController::class, 'storeAntrian'])->name('pendaftaran.antrian.store');

        Route::get('/pasien', [PendaftaranController::class, 'getPasien']);
        Route::get('/dokter', [PendaftaranController::class, 'getDokter']);
        Route::get('/jadwal', [PendaftaranController::class, 'getJadwal']);

        Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
        Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('/pengguna/reset-password/{id_pasien}', [PenggunaController::class, 'resetPassword'])->name('pengguna.reset-password');
        Route::get('/pengguna/nonaktif/{id_pasien}', [PenggunaController::class, 'nonaktifPetugas'])->name('pengguna.nonatif-petugas');

        Route::get('/search/pasien', [PendaftaranController::class, 'searchPasien'])->name('search.pasien');
        Route::get('/search/antrian', [PendaftaranController::class, 'searchAntrian'])->name('search.antrian');

    });
});

// Route::group(['middleware' => ['petugas:Poliklinik']], function () {
//     Route::prefix('poliklinik')->group(function () {
//         // Route::get('/pemeriksaan', [PemeriksaanController::class, 'index'])->name('pemeriksaan');
//         // Route::post('/pemeriksaan', [PemeriksaanController::class, 'store'])->name('pemeriksaan.store');

//     });
// });

Route::group(['middleware' => ['petugas:Dokter']], function () {
    Route::get('/diagnosis/{id_antrian}', [PemeriksaanController::class, 'diagnosis'])->name('diagnosis');
});

Route::group(['middleware' => ['petugas:*']], function () {
    Route::get('/rekam', [RekamController::class, 'index'])->name('rekam');
    Route::get('/rekam/detail/{id_pasien}/{tanggal}', [RekamController::class, 'detailByTanggal'])->name('detailByTanggal');
    Route::get('/cari', [RekamController::class, 'cari'])->name('cari');
    Route::get('/rekam-medis/cetak/{id}', [RekamController::class, 'cetakPDF'])->name('rekam-medis.cetak');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::group(['middleware' => ['petugas:Poliklinik,Dokter']], function () {
    Route::get('/pemeriksaan', [PemeriksaanController::class, 'index'])->name('pemeriksaan');
    Route::post('/pemeriksaan', [PemeriksaanController::class, 'store'])->name('pemeriksaan.store');
    Route::get('/pemeriksaan/{id_antrian}', [PemeriksaanController::class, 'detailById'])->name('pemeriksaan.detailById');
});














// Route::group(['middleware' => 'pasien'], function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
//     Route::get('/dashboard/detail/{id}', [DashboardController::class, 'detailById'])->name('admin.dashboard');
// });
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.pengguna.customer.index');