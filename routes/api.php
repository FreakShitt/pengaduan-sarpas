<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PengaduanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (tidak perlu authentication)
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes (perlu authentication dengan Sanctum)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // Homepage
    Route::get('/homepage', [PengaduanController::class, 'homepage']);

    // Pengaduan
    Route::get('/pengaduan/history', [PengaduanController::class, 'history']);
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show']);
    Route::post('/pengaduan', [PengaduanController::class, 'store']);

    // Master data
    Route::get('/lokasi', [PengaduanController::class, 'getLokasi']);
    Route::get('/barang', [PengaduanController::class, 'getBarang']);
});
