<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});

// // Route::get('/mahasiswa', function () {
// //     return 'Halo Mahasiswa';
// // })->name('mahasiswa.show');

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: '.$param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'NIM saya: '.$param1;
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
});

Route::get('/mahasiswa/{param1cls?}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/dataPegawai', [PegawaiController::class, 'index']);

Route::post('question/store', [QuestionController::class, 'store'])
		->name('question.store');

Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

Route::resource('pelanggan', PelangganController::class);

// Route untuk upload file pelanggan
Route::post('/pelanggan/{id}/upload', [PelangganController::class, 'uploadFiles'])->name('pelanggan.upload');
Route::delete('/pelanggan-file/{fileId}', [PelangganController::class, 'deleteFile'])->name('pelanggan.file.delete');

// Debug route
Route::get('/debug-upload', function () {
    $files = \App\Models\MultipleUpload::where('ref_table', 'pelanggan')->where('ref_id', 1)->get();
    dd([
        'total_files' => \App\Models\MultipleUpload::count(),
        'pelanggan_files' => $files,
        'pelanggan_count' => $files->count()
    ]);
});

Route::resource('user', UserController::class);

// Profile routes untuk upload dan manage profile picture
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/picture', [ProfileController::class, 'destroy'])->name('profile.picture.delete');

