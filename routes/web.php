<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\LembagaDesaController;
use App\Http\Controllers\AnggotaLembagaController;
use App\Http\Controllers\UserController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk menampilkan form registrasi
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// Route untuk memproses registrasi
Route::post('/register', [AuthController::class, 'register']);


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Warga Routes
    Route::resource('warga', WargaController::class)->names('admin.warga');

    // Lembaga Desa Routes
    Route::resource('lembaga', LembagaDesaController::class)->names('admin.lembaga');

    // User Management Routes
    Route::resource('user', UserController::class);

    // Anggota Lembaga Routes
        Route::get('/anggota', [AnggotaLembagaController::class, 'index'])->name('admin.lembaga.anggota.index');
        Route::get('/anggota/create', [AnggotaLembagaController::class, 'create'])->name('admin.lembaga.anggota.create');
        Route::post('/anggota', [AnggotaLembagaController::class, 'store'])->name('admin.lembaga.anggota.store');
        Route::get('/anggota/{id}/edit', [AnggotaLembagaController::class, 'edit'])->name('admin.lembaga.anggota.edit');
        Route::put('/anggota/{id}', [AnggotaLembagaController::class, 'update'])->name('admin.lembaga.anggota.update');
        Route::delete('/anggota/{id}', [AnggotaLembagaController::class, 'destroy'])->name('admin.lembaga.anggota.destroy');


Route::redirect('/', '/login');
