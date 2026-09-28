<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Import Controller Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\MakulController;
use App\Http\Controllers\Admin\KelasMakulController;
use App\Http\Controllers\Admin\DetailKelasController;
use App\Http\Controllers\Admin\PertemuanController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\AkademikController;
use App\Http\Controllers\Admin\PasswordController;

// ================= AUTH & PIN =================
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/verify-pin', [LoginController::class, 'verifyPin'])->name('pin.verify');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ================= AREA ADMIN =================   
Route::prefix('admin')->group(function () {
    // Dashboard Beranda
    Route::get('/', [DashboardController::class, 'index'])->name('admin');

    // Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('admin.pengguna');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('admin.pengguna.store');
    Route::put('/pengguna/{username}', [PenggunaController::class, 'update'])->name('admin.pengguna.update');
    Route::delete('/pengguna/{username}', [PenggunaController::class, 'destroy'])->name('admin.pengguna.destroy');

    // Dosen
    Route::get('/dosen', [DosenController::class, 'index'])->name('admin.dosen');
    Route::post('/dosen', [DosenController::class, 'store'])->name('admin.dosen.store');
    Route::put('/dosen/{nik}', [DosenController::class, 'update'])->name('admin.dosen.update');
    Route::delete('/dosen/{nik}', [DosenController::class, 'destroy'])->name('admin.dosen.destroy');
    Route::get('/dosen/excel', [DosenController::class, 'exportExcel'])->name('admin.dosen.excel');
    Route::get('/dosen/pdf', [DosenController::class, 'exportPdf'])->name('admin.dosen.pdf');

    // Mahasiswa
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
    Route::put('/mahasiswa/{nim}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
    Route::delete('/mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');

    // Jurusan
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('admin.jurusan');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('admin.jurusan.store');
    Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
    Route::delete('/jurusan/{kode_jurusan}', [JurusanController::class, 'destroy'])->name('admin.jurusan.destroy');

    // Mata Kuliah (Makul)
    Route::get('/makul', [MakulController::class, 'index'])->name('admin.makul');
    Route::post('/makul', [MakulController::class, 'store'])->name('admin.makul.store');
    Route::put('/makul/{kode_makul}', [MakulController::class, 'update'])->name('admin.makul.update');
    Route::delete('/makul/{kode_makul}', [MakulController::class, 'destroy'])->name('admin.makul.destroy');

    // Kelas Makul
    Route::get('/kelas-makul', [KelasMakulController::class, 'index'])->name('admin.kelas_makul');
    Route::post('/kelas-makul', [KelasMakulController::class, 'store'])->name('admin.kelas_makul.store');
    Route::put('/kelas-makul/{kode_kelas}', [KelasMakulController::class, 'update'])->name('admin.kelas_makul.update');
    Route::delete('/kelas-makul/{kode_kelas}', [KelasMakulController::class, 'destroy'])->name('admin.kelas_makul.destroy');

    Route::get('/kelas-makul/pertemuan/{kode_kelas}', [PertemuanController::class, 'index'])->name('admin.kelas_makul.pertemuan');
    Route::post('/kelas-makul/pertemuan/{kode_kelas}', [PertemuanController::class, 'store'])->name('admin.kelas_makul.pertemuan.store');
    Route::put('/kelas-makul/pertemuan/{id}', [PertemuanController::class, 'update'])->name('admin.kelas_makul.pertemuan.update');
    Route::delete('/kelas-makul/pertemuan/{id}', [PertemuanController::class, 'destroy'])->name('admin.kelas_makul.pertemuan.destroy');

    Route::get('kelas-makul/presensi/{id_pertemuan}', [PresensiController::class, 'index'])->name('admin.kelas_makul.presensi');
    Route::put('/kelas-makul/presensi/{id}/toggle', [PresensiController::class, 'toggleStatus'])->name('admin.kelas_makul.presensi.toggle');
    Route::put('/kelas-makul/presensi/kehadiran/{id}', [PresensiController::class, 'ubahKehadiran'])->name('admin.kelas_makul.presensi.kehadiran');
    // Detail Kelas
    Route::get('/detail-kelas', [DetailKelasController::class, 'index'])->name('admin.detail_kelas');

    // Akademik
    Route::get('/akademik', [AkademikController::class, 'index'])->name('admin.akademik');
    Route::post('/akademik', [AkademikController::class, 'store'])->name('admin.akademik.store');
    Route::put('/akademik/{kode_akd}', [AkademikController::class, 'update'])->name('admin.akademik.update');
    Route::delete('/akademik/{kode_akd}', [AkademikController::class, 'destroy'])->name('admin.akademik.destroy');

    // Password / Ganti Sandi Admin
    Route::get('/password', [PasswordController::class, 'index'])->name('admin.password');
    Route::put('/password/update', [PasswordController::class, 'update'])->name('admin.password.update');
});


// ================= DOSEN & MAHASISWA (Sementara) =================
Route::get('/dosen', function () {
    return view('dosen.index');
})->name('dosen');

Route::get('/mahasiswa', function () {
    return view('mahasiswa.index');
})->name('mahasiswa');