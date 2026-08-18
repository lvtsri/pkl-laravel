<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Route::get('/', function () {
//     return view('welcome');
// });

// LOGIN UTAMA
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// PIN
Route::post('/verify-pin', [LoginController::class, 'verifyPin'])
    ->name('pin.verify');

Route::post('/skip-pin', [LoginController::class, 'skipPin'])
    ->name('pin.skip');

Route::get('/ubah-pin', [LoginController::class, 'showChangePin'])
    ->name('ubah.pin');

Route::post('/update-pin', [LoginController::class, 'updatePin'])
    ->name('pin.update');

// Pindah ke home
Route::get('/mahasiswa', function () {
    return view('mahasiswa.index');})->name('mahasiswa');

Route::get('/admin', function () {
    return view('admin.index');})->name('admin');

Route::get('/dosen', function () {
    return view('dosen.index');})->name('dosen');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');