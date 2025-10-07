<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MuridController as AdminMuridController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\StafController as AdminStafController;
use App\Http\Controllers\Staf\StafController;
use App\Http\Controllers\Staf\TagihanController;
use App\Http\Controllers\Staf\KeuanganController;
use App\Http\Controllers\Murid\MuridController;

// =======================
// ROUTE AWAL (Landing Page)
// =======================
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// =======================
// AUTH ROUTES
// =======================
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');

// =======================
// DASHBOARD GLOBAL (setelah login)
// =======================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // =======================
    // ADMIN ROUTES
    // =======================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('murid', AdminMuridController::class)->names('murid');
        Route::resource('sekolah', SekolahController::class)->names('sekolah');
        Route::resource('guru', GuruController::class)->names('guru');
        Route::resource('staf', AdminStafController::class)->names('staf');
    });

    // =======================
    // STAF ROUTES
    // =======================
    Route::middleware(['role:staf'])->prefix('staf')->name('staf.')->group(function () {
        // Jadwal Pelajaran CRUD
        Route::get('/jadwal', [\App\Http\Controllers\Staf\JadwalPelajaranController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/create', [\App\Http\Controllers\Staf\JadwalPelajaranController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal', [\App\Http\Controllers\Staf\JadwalPelajaranController::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/{id}/edit', [\App\Http\Controllers\Staf\JadwalPelajaranController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/{id}', [\App\Http\Controllers\Staf\JadwalPelajaranController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [\App\Http\Controllers\Staf\JadwalPelajaranController::class, 'destroy'])->name('jadwal.destroy');

        // Pengumuman CRUD
        Route::get('/pengumuman', [\App\Http\Controllers\Staf\PengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('/pengumuman/terbaru/create', [\App\Http\Controllers\Staf\PengumumanController::class, 'createTerbaru'])->name('pengumuman.terbaru.create');
        Route::post('/pengumuman/terbaru', [\App\Http\Controllers\Staf\PengumumanController::class, 'storeTerbaru'])->name('pengumuman.terbaru.store');
        Route::get('/pengumuman/terbaru/{id}/edit', [\App\Http\Controllers\Staf\PengumumanController::class, 'editTerbaru'])->name('pengumuman.terbaru.edit');
        Route::put('/pengumuman/terbaru/{id}', [\App\Http\Controllers\Staf\PengumumanController::class, 'updateTerbaru'])->name('pengumuman.terbaru.update');
        Route::delete('/pengumuman/terbaru/{id}', [\App\Http\Controllers\Staf\PengumumanController::class, 'destroyTerbaru'])->name('pengumuman.terbaru.destroy');
        Route::get('/pengumuman/akademik/create', [\App\Http\Controllers\Staf\PengumumanController::class, 'createAkademik'])->name('pengumuman.akademik.create');
        Route::post('/pengumuman/akademik', [\App\Http\Controllers\Staf\PengumumanController::class, 'storeAkademik'])->name('pengumuman.akademik.store');
        Route::get('/pengumuman/akademik/{id}/edit', [\App\Http\Controllers\Staf\PengumumanController::class, 'editAkademik'])->name('pengumuman.akademik.edit');
        Route::put('/pengumuman/akademik/{id}', [\App\Http\Controllers\Staf\PengumumanController::class, 'updateAkademik'])->name('pengumuman.akademik.update');
        Route::delete('/pengumuman/akademik/{id}', [\App\Http\Controllers\Staf\PengumumanController::class, 'destroyAkademik'])->name('pengumuman.akademik.destroy');

        Route::get('/dashboard', [StafController::class, 'index'])->name('dashboard');
        Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
        Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
        Route::put('/keuangan/{id}', [KeuanganController::class, 'update'])->name('keuangan.update');
        Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');

        // Pembayaran & Tagihan
        Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
            Route::get('/', [TagihanController::class, 'index'])->name('index');
            Route::get('/{murid}/input', [TagihanController::class, 'create'])->name('input');
            Route::post('/{murid}/input', [TagihanController::class, 'store'])->name('input.store');
            Route::delete('/{murid}/input', [TagihanController::class, 'destroy'])->name('destroy');
            Route::get('/sekolah/{sekolah}/input-massal', [TagihanController::class, 'createMass'])->name('input.mass');
            Route::post('/sekolah/{sekolah}/input-massal', [TagihanController::class, 'storeMass'])->name('input.mass.store');
            Route::get('/{murid}/detail', [TagihanController::class, 'show'])->name('detail');
            Route::get('/tagihan/{id}/edit', [TagihanController::class, 'edit'])->name('edit');
            Route::put('/tagihan/{id}/edit', [TagihanController::class, 'update'])->name('update');
        });
    });

    // =======================
    // GURU ROUTES
    // =======================
    Route::middleware(['role:guru'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Guru\GuruController::class, 'index'])->name('dashboard');
        Route::get('/jadwal', [\App\Http\Controllers\Guru\JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/nilai', [\App\Http\Controllers\Guru\NilaiController::class, 'index'])->name('nilai.index');
        Route::post('/nilai', [\App\Http\Controllers\Guru\NilaiController::class, 'store'])->name('nilai.store');
        Route::post('/nilai/publish', [\App\Http\Controllers\Guru\NilaiController::class, 'publish'])->name('nilai.publish');
        Route::get('/nilai/{nilai}/edit', [\App\Http\Controllers\Guru\NilaiController::class, 'edit'])->name('nilai.edit');
        Route::put('/nilai/{nilai}', [\App\Http\Controllers\Guru\NilaiController::class, 'update'])->name('nilai.update');

        // Guru Profile CRUD
        Route::get('/profile', [\App\Http\Controllers\Guru\ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [\App\Http\Controllers\Guru\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Guru\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [\App\Http\Controllers\Guru\ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // =======================
    // MURID ROUTES
    // =======================
    Route::middleware(['role:murid'])->prefix('murid')->name('murid.')->group(function () {
        Route::get('/dashboard', [MuridController::class, 'index'])->name('dashboard');
        Route::get('/jadwal', [\App\Http\Controllers\Murid\JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/nilai', [\App\Http\Controllers\Murid\NilaiController::class, 'index'])->name('nilai.index');
        Route::get('/pembayaran', [\App\Http\Controllers\Murid\PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::put('/pembayaran/{id}', [\App\Http\Controllers\Api\PembayaranApiController::class, 'update'])->name('pembayaran.update');

        // Murid Profile CRUD
        Route::get('/profile', [\App\Http\Controllers\Murid\ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [\App\Http\Controllers\Murid\ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [\App\Http\Controllers\Murid\ProfileController::class, 'update'])->name('profile.update.post');
        Route::delete('/profile', [\App\Http\Controllers\Murid\ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});