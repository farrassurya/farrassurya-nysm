<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public registration route
Route::get('/register', [UserController::class, 'create'])->name('user.create');
Route::post('/register', [UserController::class, 'store'])->name('user.store');

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
    return 'Nama saya: ' . $param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'NIM saya: ' . $param1;
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

// Public dashboard route (accessible by guests)
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Routes untuk Super Admin
    Route::middleware(['checkrole:Super Admin'])->group(function () {
        Route::resource('user', UserController::class)->except(['create', 'store']);
    });

    // Routes untuk semua user yang login
    Route::resource('pelanggan', PelangganController::class);

    // Route untuk upload file pelanggan
    Route::post('/pelanggan/{id}/upload', [PelangganController::class, 'uploadFiles'])->name('pelanggan.upload');
    Route::delete('/pelanggan-file/{fileId}', [PelangganController::class, 'deleteFile'])->name('pelanggan.file.delete');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/picture', [ProfileController::class, 'destroy'])->name('profile.picture.delete');
});

// Debug route
Route::get('/debug-upload', function () {
    $files = \App\Models\MultipleUpload::where('ref_table', 'pelanggan')->where('ref_id', 1)->get();
    dd([
        'total_files'     => \App\Models\MultipleUpload::count(),
        'pelanggan_files' => $files,
        'pelanggan_count' => $files->count(),
    ]);
});
