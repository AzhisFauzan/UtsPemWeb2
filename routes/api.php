<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RuanganController;
use App\Http\Controllers\Api\PerangkatController;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\PeminjamanController;

/*
|--------------------------------------------------------------------------
| API Routes — Mini SIMRS
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==================== PROTECTED ROUTES (All Authenticated Users) ====================
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Ruangan — Read (all roles)
    Route::get('/ruangan', [RuanganController::class, 'index']);

    // Perangkat — Read (all roles)
    Route::get('/perangkat', [PerangkatController::class, 'index']);
    Route::get('/perangkat/{id}', [PerangkatController::class, 'show']);

    // Maintenance — Read, Create, Update (all roles)
    Route::get('/maintenance', [MaintenanceController::class, 'index']);
    Route::post('/maintenance', [MaintenanceController::class, 'store']);
    Route::put('/maintenance/{id}', [MaintenanceController::class, 'update']);

    // Peminjaman — Read, Create, Return (all roles)
    Route::get('/peminjaman', [PeminjamanController::class, 'index']);
    Route::post('/peminjaman', [PeminjamanController::class, 'store']);
    Route::put('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali']);

    // ==================== ADMIN ONLY ROUTES ====================
    Route::middleware('admin')->group(function () {

        // Ruangan — CUD (admin only)
        Route::post('/ruangan', [RuanganController::class, 'store']);
        Route::put('/ruangan/{id}', [RuanganController::class, 'update']);
        Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy']);

        // Perangkat — CUD (admin only)
        Route::post('/perangkat', [PerangkatController::class, 'store']);
        Route::put('/perangkat/{id}', [PerangkatController::class, 'update']);
        Route::delete('/perangkat/{id}', [PerangkatController::class, 'destroy']);

        // Maintenance — Delete (admin only)
        Route::delete('/maintenance/{id}', [MaintenanceController::class, 'destroy']);

        // Peminjaman — Delete (admin only)
        Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);
    });
});
