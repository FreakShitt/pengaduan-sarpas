<?php

use App\Http\Controllers\AuthController;

// ROOT - redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// LOGIN
Route::get('/login', action: [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// REGISTER
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// DASHBOARD (untuk siswa & guru)
Route::get('/dashboard', [AuthController::class, 'showDashboard'])
    ->middleware(['auth', 'role:siswa,guru'])
    ->name('dashboard');
// LOGOUT (support both GET and POST)
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// PENGADUAN (protected - untuk siswa & guru)
use App\Http\Controllers\PengaduanController;

Route::middleware(['auth', 'role:siswa,guru'])->group(function () {
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::get('/pengaduan/get-barang', [PengaduanController::class, 'getBarangByLokasi'])->name('pengaduan.get-barang');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
});

// PETUGAS (protected - untuk petugas)
use App\Http\Controllers\PetugasController;

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    Route::get('/laporan/{id}', [PetugasController::class, 'show'])->name('petugas.laporan.show');
    Route::put('/laporan/{id}/update-status', [PetugasController::class, 'updateStatus'])->name('petugas.laporan.update-status');
});

// ADMIN (protected - untuk admin)
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Petugas Management
    Route::get('/petugas', [AdminController::class, 'petugas'])->name('admin.petugas.index');
    Route::get('/petugas/create', [AdminController::class, 'createPetugas'])->name('admin.petugas.create');
    Route::post('/petugas', [AdminController::class, 'storePetugas'])->name('admin.petugas.store');
    
    // User Management (Siswa & Guru)
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    
    // Lokasi Management
    Route::get('/lokasi', [AdminController::class, 'lokasi'])->name('admin.lokasi.index');
    Route::get('/lokasi/create', [AdminController::class, 'createLokasi'])->name('admin.lokasi.create');
    Route::post('/lokasi', [AdminController::class, 'storeLokasi'])->name('admin.lokasi.store');
    Route::get('/lokasi/{id}/edit', [AdminController::class, 'editLokasi'])->name('admin.lokasi.edit');
    Route::put('/lokasi/{id}', [AdminController::class, 'updateLokasi'])->name('admin.lokasi.update');
    Route::delete('/lokasi/{id}', [AdminController::class, 'destroyLokasi'])->name('admin.lokasi.destroy');
    
    // Barang Management
    Route::get('/barang', [AdminController::class, 'barang'])->name('admin.barang.index');
    Route::get('/barang/create', [AdminController::class, 'createBarang'])->name('admin.barang.create');
    Route::post('/barang', [AdminController::class, 'storeBarang'])->name('admin.barang.store');
    Route::get('/barang/{id}/edit', [AdminController::class, 'editBarang'])->name('admin.barang.edit');
    Route::put('/barang/{id}', [AdminController::class, 'updateBarang'])->name('admin.barang.update');
    Route::delete('/barang/{id}', [AdminController::class, 'destroyBarang'])->name('admin.barang.destroy');
    
    // Item Requests Management
    Route::get('/item-requests', [AdminController::class, 'itemRequests'])->name('admin.item-requests.index');
    Route::post('/item-requests/{id}/approve', [AdminController::class, 'approveItemRequest'])->name('admin.item-requests.approve');
    Route::post('/item-requests/{id}/reject', [AdminController::class, 'rejectItemRequest'])->name('admin.item-requests.reject');
    
    // Laporan
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/laporan/export-pdf', [AdminController::class, 'exportPdf'])->name('admin.laporan.export-pdf');
    Route::get('/laporan/export-doc', [AdminController::class, 'exportDoc'])->name('admin.laporan.export-doc');
    
    // Pengaduan Detail & Update Status (Admin can manage like petugas)
    Route::get('/pengaduan/{id}', [AdminController::class, 'showPengaduan'])->name('admin.pengaduan.show');
    Route::put('/pengaduan/{id}/update-status', [AdminController::class, 'updateStatusPengaduan'])->name('admin.pengaduan.update-status');
});
